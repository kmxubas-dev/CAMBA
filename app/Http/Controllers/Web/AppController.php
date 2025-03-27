<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAuction;
use App\Models\ProductPurchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $user = User::find(Auth::id());
        $products_count = $user->products()->count();
        $auctions_count = $user->products()->whereHas('auction')->count();
        $bids_count = $user->bids()->count();
        $purchases_count = $user->purchases()->count();

        $products = Product::with('user')
            ->where('user_id', '!=', Auth::id())
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return view('dashboard', compact(
            'products_count', 'auctions_count', 'bids_count', 'purchases_count', 'products'
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
     * Profile - Update
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'fname' => 'required|string|max:100',
            'lname' => 'required|string|max:100',
            'birthdate' => 'nullable|date',
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $user->update([
            'fname' => $validated['fname'],
            'lname' => $validated['lname'],
        ]);

        $user->info()->updateOrCreate([], [
            'birthdate' => $validated['birthdate'] ?? null,
            'contact' => $validated['contact'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);
        
        if ($request->hasFile('profile_photo')) {
            if (
                $user->profile_photo_path &&
                !str_contains($user->profile_photo_path, 'img/placeholders/')
            ) {
                $oldPath = str_replace('/storage/', '', $user->profile_photo_path);
            
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }            
        
            $newPhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = Storage::url($newPhotoPath);
            $user->save();
        }

        return redirect()
            ->route('custom.profile.show', $user)
            ->with('success', 'Profile updated successfully.');
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
