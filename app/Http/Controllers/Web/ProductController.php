<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Auth::user()->products()->paginate(8);
        return view('_user.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('_user.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'attributes.type' => 'required|string|max:255',
            'attributes.year' => 'required|integer|max:' . date('Y'),
            'attributes.size' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
            'description' => 'required|string',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageFilePath = null;

        if ($request->hasFile('images')) {
            $imageFilePath = $request->file('images')->store('products', 'public');
        }

        $data = $request->all();
        $data['images'] = $imageFilePath ? Storage::url($imageFilePath) : null;

        $product = Auth::user()->products()->create($data);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Artwork created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('_user.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('_user.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'attributes.type' => 'required|string|max:255',
            'attributes.year' => 'required|integer|max:' . date('Y'),
            'attributes.size' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
            'description' => 'required|string',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('images')) {
            if ($product->images && !str_contains($product->images, 'img/placeholders/')) {
                $oldPath = str_replace('/storage/', '', $product->images);

                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $imageFilePath = $request->file('images')->store('products', 'public');
            $data['images'] = Storage::url($imageFilePath);
        }

        $product->update($data);

        return redirect()
            ->route('products.show', $product->id)
            ->with('success', 'Artwork updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->images && !str_contains($product->images, 'img/placeholders/')) {
            $imagePath = str_replace('/storage/', '', $product->images);

            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $product->bids()->delete();
        $product->auction()->delete();
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Artwork and its related data deleted successfully!');
    }

    // -------------------------------------------------------------------------------- //
    
    public function index_buyer(Request $request)
    {
        $products = Product::with('user', 'auction')->where('user_id', '!=', Auth::id())
            ->inRandomOrder()
            ->paginate(8);

        if ($request->ajax()) {
            return response()->json([
                'products' => $products->items(),
                'next_page_url' => $products->nextPageUrl(),
            ]);
        }

        return view('_user.products.index_buyer', compact('products'));
    }
}
