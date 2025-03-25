<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAuction;
use App\Models\ProductPurchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    /**
     * Welcome
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        $users = User::withCount(['products', 'auctions', 'purchases'])
            ->where('type', '!=', 'admin')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('welcome', compact('users'));
    }

    /**
     * Dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = User::find(Auth::user()->id);
        $products_count = $user->products()->count();
        $auctions_count = $user->products()->whereHas('auction')->count();
        $bids_count = $user->bids()->count();

        $products = Product::inRandomOrder()->limit(8)->get();

        return view('dashboard', compact(
            'products_count', 'auctions_count', 'bids_count', 'products'
        ));
    }

    /**
     * Profile
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return 'Profile';
    }

    /**
     * Profile
     *
     * @return \Illuminate\Http\Response
     */
    public function showProfile(User $user)
    {
        $user->load([
            'info',
            'products' => function ($query) {
                $query->inRandomOrder()->take(6);
            },
            'auctions' => function ($query) {
                $query->inRandomOrder()->take(6);
            },
            'purchases' => function ($query) {
                $query->inRandomOrder()->take(6);
            }
        ]);

        return view('_user.profile_show', compact('user'));
    }

    /**
     * Search
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $user = Auth::user();

        $products = Product::with('user')
            ->where('name', 'like', '%' . $query . '%')
            ->take(6)
            ->get();

        $auctionProducts = ProductAuction::whereHas('product', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->with('product')
            ->take(6)
            ->get();

        $purchaseProducts = ProductPurchase::whereHas('product', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->where('user_id', $user->id)
            ->with('product')
            ->take(6)
            ->get();

        return view('_user.search', compact('products', 'auctionProducts', 'purchaseProducts', 'query'));
    }

}
