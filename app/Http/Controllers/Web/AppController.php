<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
        $users = User::withCount([
                        'products',
                        'products as auctions_count' => function ($query) {
                            $query->whereHas('auction');
                        }
                    ])
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
}
