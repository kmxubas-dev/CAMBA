<x-app-layout>
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'My Auctions', 'url' => route('auctions.index')],
            ['label' => 'Start Auction']
        ]
    ])

    <!-- Main Section -->
    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">Start an Auction</h3>

            <a href="{{ route('auctions.index') }}" class="btn btn-purple w-auto rounded-xl px-3 py-1.5 shadow-lg">
                <i class="ri-arrow-left-line text-xl"></i>
                <span>My Auctions</span>
            </a>
        </div>

        <!-- Search Bar Section -->
        <div class="text-center">
            <h2 class="text-xl font-bold text-purple-800">Choose a Product to Auction</h2>
            <p class="text-sm text-purple-600">Search and click on one of your products below to start an auction.</p>
        </div>
        <form method="GET" action="{{ route('auctions.create') }}" class="mb-5 flex items-center justify-center space-x-4">
            <div class="relative w-full max-w-xl">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search for products to be auctioned..."
                    value="{{ $search }}"
                    class="w-full rounded-full bg-gradient-to-r from-purple-300 to-pink-200 py-3 pl-12 pr-6 text-sm text-purple-900 placeholder-gray-500 shadow-md transition duration-300 ease-in-out hover:bg-gradient-to-l hover:from-purple-400 hover:to-pink-300 focus:outline-none focus:ring-2 focus:ring-purple-400"
                />
                <!-- Search Icon inside the input -->
                <div class="absolute left-4 top-1/2 -translate-y-1/2 transform text-gray-500">
                    <i class="ri-search-line text-xl"></i>
                </div>
            </div>

            <!-- Optional Search Button (For mobile view) -->
            <button type="submit" class="items-center justify-center rounded-full bg-purple-600 px-6 py-2 text-white transition-all duration-300 ease-in-out hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-300 lg:hidden">
                <i class="ri-search-line text-xl"></i>
            </button>
        </form>

        <!-- Product Cards Grid -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($products as $product)
                <form method="POST" action="{{ route('auctions.store') }}" onsubmit="return confirm('Are you sure you want to start an auction for this product?');">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <button type="submit" class="group w-full text-left" {{ $product->auction ? 'disabled' : '' }}>
                        <div class="relative flex h-full transform flex-col overflow-hidden rounded-xl border border-purple-300 bg-white shadow-sm transition-transform hover:scale-105 hover:bg-gradient-to-r hover:from-purple-200 hover:to-purple-100 hover:shadow-md">
                            <!-- Reduced image size -->
                            <img 
                                src="{{ asset($product->images) }}" 
                                alt="{{ $product->name }}" 
                                class="h-24 w-full rounded-t-xl object-cover transition duration-300" />

                            <div class="flex flex-grow flex-col space-y-1 px-3 py-1"> <!-- Reduced padding and added small space between elements -->
                                <h3 class="text-sm font-semibold text-purple-800 group-hover:text-purple-600">{{ $product->name }}</h3>
                                <p class="mt-1 line-clamp-2 text-xs text-purple-600">{{ Str::limit($product->description, 35) }}</p>
                            </div>

                            <div class="absolute left-3 top-3 rounded-full bg-gradient-to-r from-purple-500 to-purple-700 px-2 py-1 text-xs font-medium text-white">
                                ₱{{ number_format($product->price, 2) }}
                            </div>

                            <div class="px-3 text-xs text-purple-600">
                                <span class="font-semibold">Type:</span> {{ $product->attributes['type'] ?? 'N/A' }}
                            </div>

                            <div class="px-3 text-xs text-purple-600">
                                <span class="font-semibold">Year:</span> {{ $product->attributes['year'] ?? 'N/A' }}
                            </div>

                            <div class="px-3 text-xs text-purple-600">
                                <span class="font-semibold">Size:</span> {{ $product->attributes['size'] ?? 'N/A' }}
                            </div>

                            @if ($product->auction)
                                <div class="absolute right-2 top-2 rounded-full bg-red-500 px-2 py-1 text-xs text-white">
                                    <span>Ongoing Auction</span>
                                </div>
                            @endif

                            <div class="pb-3"></div>
                        </div>
                    </button>
                </form>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $products->appends(['search' => $search])->links() }}
        </div>
    </section>
</x-app-layout>
