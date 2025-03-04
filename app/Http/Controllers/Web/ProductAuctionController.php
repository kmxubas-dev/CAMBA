<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ProductAuction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductAuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auctions = ProductAuction::with(['product', 'bids'])
            ->whereHas('product', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('end', 'desc')
            ->paginate(6);

        $auctions->getCollection()->transform(function ($auction) {
            $timeRemaining = Carbon::now()->diffInSeconds($auction->end, false);
            $auction->timeRemaining = $timeRemaining > 0 ? $timeRemaining : 0;
            return $auction;
        });

        return view('_user.auctions.index', compact('auctions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $search = $request->get('search');

        $products = Auth::user()
            ->products()
            ->doesntHave('auction')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('_user.auctions.create', compact('products', 'search'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
        ]);
    
        $auction = new ProductAuction();
        $auction->product_id = $validated['product_id'];
        $auction->price = $validated['price'];
        $auction->start = Carbon::now()->setSeconds(0);
        $auction->end = Carbon::now()->addDay()->setSeconds(0);
        $auction->save();

        return redirect()
            ->route('auctions.show', $auction)
            ->with('success', 'Auction started successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductAuction $auction)
    {
        $auction->load(['product', 'bids.user']);

        $timeRemaining = Carbon::now()->diffInSeconds($auction->end, false);
        $timeRemaining = $timeRemaining > 0 ? $timeRemaining : 0;

        $bids_top10 = $auction->bids()->orderByDesc('amount')->take(10)->get();

        return view('_user.auctions.show', [
            'auction' => $auction,
            'bids_top10' => $bids_top10,
            'timeRemaining' => $timeRemaining,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductAuction $auction)
    {
        if ($auction->status === 'sold') {
            return redirect()
                ->back()
                ->with('error', 'Sold artwork auctions can’t be edited.');
        }

        return view('_user.auctions.edit', compact('auction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductAuction $auction)
    {
        $validatedData = $request->validate([
            'price' => ['numeric', 'min:0', function ($attribute, $value, $fail) use ($auction) {
                if ($value < $auction->product->price) {
                    $fail("The price must be at least {$auction->product->price}");
                }
            }],
            'start' => ['date', function ($attribute, $value, $fail) use ($auction) {
                $start = Carbon::parse($value);
                $now = now();
    
                if ($start->lt($auction->start)) {
                    $fail('The start date must be after the previous auction start.');
                }
    
                if ($start->gt($now)) {
                    $fail('The start date cannot be in the future.');
                }
            }],
            'end' => 'date|after:start',
            'status' => 'in:active,paused,ended,sold',
        ]);
    
        if ($request->input('action_type') === 'restart') {
            $auction->bids()->delete();
        }
    
        $auction->update($validatedData);
    
        return redirect()
            ->route('auctions.show', $auction)
            ->with('success', 'Auction updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductAuction $auction)
    {
        if ($auction->status === 'sold') {
            return redirect()->back()->with('error', 'Sold auctions cannot be deleted.');
        }
    
        $auction->bids()->delete();
        $auction->delete();
    
        return redirect()
            ->route('products.show', $auction->product)
            ->with('success', 'The auction and its bids have been deleted.');
    }
}
