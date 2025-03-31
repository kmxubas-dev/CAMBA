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
    public function create()
    {
        $products = Product::with('user', 'auction')->where('user_id', '!=', Auth::id())
            ->inRandomOrder()
            ->paginate(8);

        return view('_user.purchases.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:products,product_auctions',
            'id' => 'required|integer|exists:' . $request->input('type') . ',id',
        ]);

        $purchasable = $validated['type'] === 'products'
            ? Product::findOrFail($validated['id'])
            : ProductAuction::with('bids', 'product')->findOrFail($validated['id']);

        $product = $validated['type'] === 'products'
            ? $purchasable
            : $purchasable->product;

        if ($product->qty < 1) {
            return back()->with('error', 'Product is out of stock.');
        }

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

        $amount = isset($highestBid) ? $highestBid->amount : $product->price;

        $purchase = new ProductPurchase();
        $purchase->user_id = Auth::id();
        $purchase->product_id = $product->id;
        $purchase->amount = $amount;
        $purchase->status = 'requested';
        $purchase->purchase_info = [
            'code' => 'CMB-'.now()->format('Ymd').'-'.strtoupper(substr(md5(microtime()), 0, 8)),
            'product_snapshot' => $product->toArray(),
        ];
        $purchase->payment_info = [
            'method' => null,
            'status' => null,
            'gateway' => null,
            'reference' => null,
        ];
        $purchase->purchasable()->associate($purchasable);
        $purchase->save();

        return redirect()
            ->route('purchases.edit.payment', $purchase)
            ->with('success', 'Purchase successfully created!');
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
            'status' => 'nullable|string|in:pending,successful',
            'payment_info.method' => 'nullable|string|in:gcash,grab_pay,maya,cod',
            'payment_info.status' => 'nullable|string|in:pending,paid,failed',
            'payment_info.gateway' => 'nullable|string|in:paymongo',
            'payment_info.reference' => 'nullable|string|max:255',
        ]);

        $purchase->update($validated);

        return redirect()
            ->route('purchases.show', $purchase)
            ->with('success', 'Purchase successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductPurchase $purchase)
    {
        $purchase->delete();

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase successfully deleted!');
    }

    // -------------------------------------------------------------------------------- //

    public function paymentEdit(ProductPurchase $purchase)
    {
        $product = $purchase->product;

        return view('_user.purchases.edit_payment', compact('purchase', 'product'));
    }

    public function paymentUpdate(Request $request, ProductPurchase $purchase)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string|in:gcash,grab_pay,maya,cod',
        ]);

        if ($validated['payment_method'] === 'cod') {
            session([
                'pending_purchase_payment' => [
                    'purchase_id' => $purchase->id,
                    'purchase_update' => [
                        'status' => 'paid',
                        'payment_info' => [
                            'method' => 'cod',
                            'status' => 'paid',
                            'gateway' => null,
                            'reference' => null,
                        ],
                    ],
                ]
            ]);

            return redirect()->route('purchases.paymongo.success');
        }

        $paymongo = new PayMongoService;

        $source = $paymongo->createEwalletSource(
            (int)round($purchase->amount * 100), // In centavos
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
            'pending_purchase_payment' => [
                'purchase_id' => $purchase->id,
                'purchase_update' => [
                    'status' => 'paid',
                    'payment_info' => [
                        'method' => $validated['payment_method'],
                        'status' => 'paid',
                        'gateway' => 'paymongo',
                        'reference' => $source['data']['id'],
                    ],
                ],
            ]
        ]);

        return redirect($source['data']['attributes']['redirect']['checkout_url']);
    }

    public function paymongoSuccess()
    {
        // REMINDER:
        // In production, NEVER assume payment success just from the success redirect.
        // Use the PayMongo webhook to confirm the payment status (source.paid).
        // 1. Wait for the webhook call (POST /webhooks) to confirm 'paid' status.
        // 2. If the status is 'paid', process the purchase.
        // 3. If the status is 'failed', notify the user and do not proceed.
        //
        // For now, we assume payment is successful in dev for testing.

        $session = session('pending_purchase_payment');

        if (!$session) {
            return redirect()
                ->route('purchases.index')
                ->with('error', 'Session expired or invalid.');
        }

        $purchase = ProductPurchase::findOrFail($session['purchase_id']);
        $purchase->update($session['purchase_update']);
        $purchase->product->decrement('qty');

        $purchasable = $purchase->purchasable;
        if ($purchasable instanceof \App\Models\ProductAuction) {
            $purchasable->update(['status' => 'sold']);
        }

        session()->forget('pending_purchase_payment');

        return redirect()
            ->route('purchases.edit', $purchase->id)
            ->with('success', 'Payment successful!');
    }

    public function paymongoFailed()
    {
        session()->forget('pending_purchase_payment');

        return redirect()
            ->route('purchases.index')
            ->with('error', 'Payment failed or was cancelled.');
    }

    // -------------------------------------------------------------------------------- //
}
