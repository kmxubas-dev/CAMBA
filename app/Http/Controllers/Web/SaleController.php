<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ProductPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = request('status');

        $query = Auth::user()->sales()->orderBy('product_purchases.created_at', 'desc');

        if ($status) {
            $query->where('product_purchases.status', $status);
        }

        $purchases = $query->paginate(10);

        return view('_user.sales.index', compact('purchases', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('_user.sales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductPurchase $sale)
    {
        if ($sale->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $sale->load('product');
        $purchase = $sale;

        return view('_user.sales.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductPurchase $sale)
    {
        $sale->load(['product', 'purchasable']);
        $purchase = $sale;

        return view('_user.sales.edit', compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductPurchase $sale)
    {
        $validated = $request->validate([
            'status' => 'nullable|string|in:pending',
        ]);

        $sale->update($validated);

        return redirect()
            ->route('sales.show', $sale)
            ->with('success', 'Sale successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductPurchase $sale)
    {
        //
    }
}
