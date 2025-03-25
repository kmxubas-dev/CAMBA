<x-app-layout>
    <div class="w-full px-4 py-3">

        {{-- Search Form --}}
        <form action="{{ route('search') }}" method="GET" class="mb-6 rounded-lg border-b border-b-gray-100 bg-white p-4 shadow-xl">
            <div class="relative w-full">
                <input 
                    type="text" 
                    name="query" 
                    value="{{ request('query') }}" 
                    class="w-full rounded-md border border-gray-300 bg-gray-50 py-2 pl-10 pr-4 text-sm text-gray-800 transition duration-300 ease-in-out focus:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-400" 
                    placeholder="Search..."
                >
                <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-gray-600"></i>
            </div>
        </form>

        {{-- Search Results --}}
        <h1 class="mb-6 text-center text-2xl font-bold text-gray-600">
            Search Results for "<span class="text-pink-600">{{ $query }}</span>"
        </h1>

        {{-- Products --}}
        <div class="mb-5">
            <h2 class="mb-4 text-xl font-semibold">Products</h2>
            @if ($products->isEmpty())
                <p class="text-gray-500">No products found.</p>
            @else
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($products as $product)
                        <div class="transform rounded-lg bg-white bg-gradient-to-r from-purple-100 via-pink-100 to-white p-3 shadow-md transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg">
                            {{-- Flex container for Image and Content --}}
                            <div class="flex items-center space-x-3">
                                {{-- Product Image --}}
                                <div class="flex-shrink-0">
                                    <img 
                                        src="{{ asset($product->images) }}" 
                                        alt="Product Image" 
                                        class="h-14 w-14 rounded-full object-cover"
                                    >
                                </div>
                                {{-- Product Info --}}
                                <div class="text-xs">
                                    <a href="{{ route('products.show', $product->id) }}" class="block text-base font-bold text-purple-800 hover:text-purple-700 hover:underline">
                                        {{ $product->name }}
                                    </a>
                                    {{-- Seller Name --}}
                                    <p class="text-purple-600">
                                        by: {{ $product->user->name }}
                                    </p>
                                    {{-- Product Price --}}
                                    <p class="font-semibold text-fuchsia-600">
                                        ₱{{ number_format($product->price, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('products.index.buyer') }}" class="font-semibold text-purple-600 hover:text-purple-800">View More Products</a>
                </div>
            @endif
        </div>

        {{-- Product Auctions --}}
        <div class="mb-5">
            <h2 class="mb-4 text-xl font-semibold">Product Auctions</h2>
            @if ($auctionProducts->isEmpty())
                <p class="text-gray-500">No auctions found.</p>
            @else
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($auctionProducts as $auction)
                        <div class="transform rounded-lg bg-white bg-gradient-to-r from-purple-100 via-pink-100 to-white p-3 shadow-md transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg">
                            {{-- Flex container for Image and Content --}}
                            <div class="flex items-center space-x-3">
                                {{-- Auction Image (Small) --}}
                                <div class="flex-shrink-0">
                                    <img 
                                        src="{{ asset($auction->product->images) }}" 
                                        alt="Auction Image" 
                                        class="h-14 w-14 rounded-full object-cover"
                                    >
                                </div>
                                {{-- Auction Info --}}
                                <div class="text-xs">
                                    <a href="{{ route('auctions.show', $auction->id) }}" class="block text-base font-bold text-purple-800 hover:text-purple-700 hover:underline">
                                        {{ $auction->product->name }}
                                    </a>

                                    {{-- Status --}}
                                    <p class="text-purple-600">
                                        <strong>Status:</strong> {{ ucfirst($auction->status) }}
                                    </p>

                                    {{-- Winning Bid --}}
                                    <p class="text-purple-600">
                                        <strong>Winning Bid:</strong>
                                        <span class="text-fuchsia-600">
                                            ₱{{ number_format($auction->bids->max('amount') ?? 0, 2) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('auctions.index.buyer') }}" class="font-semibold text-purple-600 hover:text-purple-800">View More Auctions</a>
                </div>
            @endif
        </div>

        {{-- Product Purchases --}}
        <div class="mb-5">
            <h2 class="mb-4 text-xl font-semibold">Product Purchases</h2>
            @if ($purchaseProducts->isEmpty())
                <p class="text-gray-500">No purchases found.</p>
            @else
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($purchaseProducts as $purchase)
                        <div class="transform rounded-lg bg-white bg-gradient-to-r from-purple-100 via-pink-100 to-white p-3 shadow-md transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg">
                            {{-- Flex container for Image and Content --}}
                            <div class="flex items-center space-x-3">
                                {{-- Purchase Image (Smaller) --}}
                                <div class="flex-shrink-0">
                                    <img 
                                        src="{{ asset($purchase->product->images) }}" 
                                        alt="Purchase Image" 
                                        class="h-14 w-14 rounded-full object-cover"
                                    >
                                </div>
                                {{-- Purchase Content --}}
                                <div class="text-xs">
                                    {{-- Product Name --}}
                                    <a href="{{ route('purchases.show', $purchase->id) }}" class="block text-base font-bold text-purple-800 hover:text-purple-700 hover:underline">
                                        {{ $purchase->product->name }}
                                    </a>

                                    {{-- Purchase Code --}}
                                    <p class="font-semibold text-purple-500">#{{ $purchase->purchase_info['code'] ?? 'N/A' }}</p>
                                    
                                    {{-- Purchase Amount (Formatted with PHP Sign) --}}
                                    <p class="text-fuchsia-600">
                                        ₱{{ number_format($purchase->amount, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('purchases.index') }}" class="font-semibold text-purple-600 hover:text-purple-800">View More Purchases</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
