<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ProductAuction;
use App\Models\ProductBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductBidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bids = Auth::user()->bids()->with('auction.product')->latest()->paginate(12);

        return view('_user.bids.index', compact('bids'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(ProductBid $bid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductBid $bid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductBid $bid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductBid $bid)
    {
        $bid->delete();
    
        return redirect()
            ->route('auctions.show', $bid->auction)
            ->with('success', 'The bid has been deleted successfully.');
    }

    // -------------------------------------------------------------------------------- //
    
    /**
     * Store or update the user's bid for a product auction.
     */
    public function storeOrUpdate(Request $request, ProductAuction $auction)
    {
        $highestBid = $auction->bids()->max('amount');

        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) use ($auction, $highestBid) {
                    if ($highestBid !== null && $value <= $highestBid) {
                        return $fail('Your bid must be higher than the current highest bid.');
                    }

                    if ($highestBid === null && $value < $auction->price) {
                        return $fail('Your bid must be at least the auction starting price.');
                    }
                }
            ],
        ]);

        $user = $request->user();

        $bid = $user->bids()->firstOrNew([
            'auction_id' => $auction->id,
        ]);

        $bid->amount = $request->input('amount');

        if (!$bid->exists) {
            $bid->user_id = $user->id;
            $bid->auction_id = $auction->id;
        }

        $bid->save();

        return back()->with('success', 'Your bid has been submitted successfully.');
    }
}
