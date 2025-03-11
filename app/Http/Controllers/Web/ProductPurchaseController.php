<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAuction;
use App\Models\ProductPurchase;
use App\Services\PayMongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Auth::user()->purchases()->orderBy('created_at', 'desc')->paginate(10);

        return view('_user.purchases.index', compact('purchases'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:products,product_auctions',
            'id' => 'required|integer|exists:' . $request->input('type') . ',id',
        ]);

        $purchasable_type = $validated['type'];
        $purchasable_id = $validated['id'];

        if ($purchasable_type === 'products') {
            $product = Product::findOrFail($purchasable_id);
        } else {
            $auction = ProductAuction::findOrFail($purchasable_id);
            $product = $auction->product;
        }

        return view('_user.purchases.create', compact(
            'product', 'purchasable_type', 'purchasable_id'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PayMongoService $payMongo)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string|in:gcash,grab_pay,maya,cod',
            'type' => 'required|string|in:products,product_auctions',
            'id' => 'required|integer|exists:' . $request->input('type') . ',id',
        ]);

        $purchasable = $validated['type'] === 'products'
            ? Product::findOrFail($validated['id'])
            : ProductAuction::with('bids', 'product')->findOrFail($validated['id']);

        $product = $validated['type'] === 'products'
            ? $purchasable
            : $purchasable->product;

        if ($validated['type'] === 'product_auctions') {
            $highestBid = $purchasable->bids->sortByDesc('amount')->first();

            if (
                $purchasable->status !== 'ended' ||
                !$highestBid ||
                $highestBid->user_id !== Auth::id()
            ) {
                return back()
                    ->with('error', 'You are not allowed to purchase from this auction.');
            }
        }

        if ($product->qty < 1) {
            return back()->with('error', 'Product is out of stock.');
        }

        $amount = isset($highestBid) ? $highestBid->amount : $product->price;

        if ($validated['payment_method'] === 'cod') {
            $purchase = $this->handleStore($product, $purchasable, $amount, [
                'method' => 'cod',
                'status' => 'successful',
                'source_id' => null,
                'gateway' => null,
            ], 'successful');

            $product->decrement('qty');

            if (isset($purchasable->status) && $validated['type'] === 'product_auctions') {
                $purchasable->update(['status' => 'sold']);
            }

            return redirect()
                ->route('purchases.index')
                ->with('success', 'Purchase successfully created!');
        }

        $source = $payMongo->createEwalletSource(
            (int)round($amount * 100), // In centavos
            $validated['payment_method'],
            [
                'success' => route('purchases.paymongo.success'),
                'failed' => route('purchases.paymongo.failed'),
            ]
        );        

        if (isset($source['errors'])) {
            return back()->with('error', 'Payment could not be initialized.');
        }

        session([
            'pending_purchase' => [
                'product_id' => $product->id,
                'purchasable_id' => $purchasable->id,
                'purchasable_type' => $validated['type'],
                'amount' => $amount,
                'payment_method' => $validated['payment_method'],
                'source_id' => $source['data']['id'],
            ]
        ]);

        return redirect($source['data']['attributes']['redirect']['checkout_url']);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductPurchase $purchase)
    {
        if ($purchase->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $purchase->load('product');

        return view('_user.purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductPurchase $purchase)
    {
        $purchase->load(['product', 'purchasable']);

        return view('_user.purchases.edit', compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductPurchase $purchase)
    {
        $validated = $request->validate([
            'status' => 'nullable|string|in:pending,successful,failed,received',
            'payment_info.method' => 'nullable|string|in:gcash,grab_pay,maya,cod',
            'payment_info.status' => 'nullable|string|in:pending,successful,failed',
            'payment_info.reference_id' => 'nullable|string|max:255',
        ]);

        $purchase->update($validated);

        return back()->with('success', 'Purchase successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductPurchase $purchase)
    {
        $purchase->delete();

        return back()->with('success', 'Purchase successfully deleted!');
    }

    // -------------------------------------------------------------------------------- //

    public function paymongoSuccess(PayMongoService $payMongo)
    {
        // REMINDER:
        // In production, NEVER assume payment success just from the success redirect.
        // Use the PayMongo webhook to confirm the payment status (source.paid).
        // 1. Wait for the webhook call (POST /webhooks) to confirm 'paid' status.
        // 2. If the status is 'paid', process the purchase.
        // 3. If the status is 'failed', notify the user and do not proceed.
        //
        // For now, we assume payment is successful in dev for testing.

        $session = session('pending_purchase');

        if (!$session) {
            return redirect()
                ->route('purchases.index')
                ->with('error', 'Session expired or invalid.');
        }

        $product = Product::findOrFail($session['product_id']);
        $purchasable = $session['purchasable_type'] === 'products'
            ? Product::findOrFail($session['purchasable_id'])
            : ProductAuction::findOrFail($session['purchasable_id']);


        $purchase = $this->handleStore($product, $purchasable, $session['amount'], [
            'method' => $session['payment_method'],
            'status' => 'successful',
            'source_id' => $session['source_id'],
            'gateway' => 'paymongo',
        ], 'successful');

        $product->decrement('qty');

        if ($session['purchasable_type'] === 'product_auctions') {
            $purchasable->update(['status' => 'sold']);
        }

        session()->forget('pending_purchase');

        return redirect()->route('purchases.index')->with('success', 'Payment successful!');
    }

    public function paymongoFailed()
    {
        session()->forget('pending_purchase');

        return redirect()
            ->route('purchases.index')
            ->with('error', 'Payment failed or was cancelled.');
    }

    // -------------------------------------------------------------------------------- //
    
    protected function handleStore($product, $purchasable, $amount, $payment, $status)
    {
        $purchase = new ProductPurchase();
        $purchase->user_id = Auth::id();
        $purchase->product_id = $product->id;
        $purchase->amount = $amount;
        $purchase->status = $status;
        $purchase->purchase_info = [
            'code' => 'CMB-'.now()->format('Ymd').'-'.strtoupper(substr(md5(microtime()), 0, 8)),
            'product_snapshot' => $product->toArray(),
        ];
        $purchase->payment_info = $payment;
        $purchase->purchasable()->associate($purchasable);
        $purchase->save();

        return $purchase;
    }
}
