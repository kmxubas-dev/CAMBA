<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAuction;
use App\Models\ProductPurchase;
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
        // Validate the incoming request
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string|in:gcash,grab_pay,maya,cod',
            'type' => 'required|string|in:products,product_auctions',
            'id' => 'required|integer|exists:' . $request->input('type') . ',id',
        ]);
    
        if ($validated['type'] === 'products') {
            $product = Product::findOrFail($validated['id']);
        } else {
            $auction = ProductAuction::with('bids')->findOrFail($validated['id']);
            $product = $auction->product;
    
            $highestBid = $auction->bids->sortByDesc('amount')->first();
    
            if ($auction->status !== 'ended' || !$highestBid || $highestBid->user_id !== Auth::id()) {
                return back()->with('error', 'You are not allowed to purchase from this auction.');
            }
        }
    
        if ($product->qty < 1) {
            return back()->with('error', 'Product is out of stock.');
        }
    
        $isCod = $validated['payment_method'] === 'cod';
    
        $purchase = new ProductPurchase();
        $purchase->user_id = Auth::id();
        $purchase->product_id = $product->id;
        $purchase->amount = isset($auction) ? $highestBid->amount : $product->price;
        $purchase->status = $isCod ? 'successful' : 'pending';
        $purchase->payment_info = [
            'method' => $validated['payment_method'],
            'status' => $isCod ? 'successful' : 'pending',
        ];
        $purchase->purchase_info = [
            'code' => 'CMB-' . now()->format('Ymd') . '-' . strtoupper(substr(md5(microtime()), 0, 8)),
            'product_snapshot' => $product->toArray(),
        ];
    
        $purchase->purchasable()->associate(
            $validated['type'] === 'products' ? $product : $auction
        );
    
        $purchase->save();
    
        $product->decrement('qty');
    
        if (isset($auction)) {
            $auction->update(['status' => 'sold']);
        }
    
        return redirect()
            ->route('purchases.index')
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
}
