<x-app-layout>
    <!-- Breadcrumb -->
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'Purchases', 'url' => route('purchases.index')],
            ['label' => 'Create']
        ]
    ])

    <!-- Main Section -->
    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">Artworks to purchase</h3>

            <a href="{{ route('purchases.index') }}"
               class="btn btn-purple w-auto rounded-xl px-3 py-1.5 shadow-lg">
                <i class="ri-arrow-left-line text-xl"></i>
                <span>All Purchases</span>
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="flex items-center rounded-lg border-2 border-purple-400 bg-purple-200 p-3 py-2">
                <i class="ri-check-line text-2xl text-purple-600"></i>
                <span class="ml-2 text-sm font-semibold text-fuchsia-600">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Artwork Cards Grid -->
        <div class="grid w-full gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($products as $product)
                <div class="relative flex flex-col overflow-hidden rounded-xl bg-gradient-to-tl from-purple-700 via-purple-900 to-indigo-800 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-yellow-500/30 hover:ring-2 hover:ring-yellow-400">
                    
                    <!-- Clickable Overlay -->
                    <a href="{{ route('products.show', $product) }}" class="absolute inset-0 z-20">&nbsp;</a>

                    <!-- Artwork Image -->
                    <div class="relative h-32 w-full overflow-hidden sm:h-40 md:h-48 lg:h-56">
                        <img src="{{ asset($product->images) }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">

                        <!-- Auctioned Badge (Visible only if the product has an auction) -->
                        @if ($product->auction) 
                            <div class="absolute left-2 top-2 z-20 flex items-center gap-1 rounded-full bg-yellow-500 px-3 py-1 text-xs font-semibold text-gray-800 shadow-md">
                                <i class="ri-gavel-line text-sm"></i> Auctioned
                            </div>
                        @endif
                    </div>

                    <!-- Artwork Details -->
                    <div class="z-10 p-3 text-white">
                        <!-- Product Title -->
                        <h3 class="truncate text-sm font-semibold text-yellow-400">
                            {{ $product->name }}
                        </h3>
                        <div class="text-xs text-gray-300">
                            by: <span class="text-yellow-200">{{ $product->user->name }}</span>
                        </div>

                        <!-- Compact Product Info -->
                        <div class="mt-1 text-xs text-gray-300">
                            <p>{{ $product->attributes['year'] }} • {{ $product->attributes['type'] }}</p>
                            <p>{{ $product->attributes['size'] }}</p>
                        </div>

                        <!-- Price and Auction Info -->
                        <div class="mt-3 flex items-center justify-between text-sm">
                            <p class="font-semibold text-yellow-400">
                                ₱{{ number_format($product->price, 2) }}
                            </p>

                            @if ($product->auction)
                                <div class="flex items-center gap-1 text-xs text-yellow-300">
                                    <i class="ri-auction-line text-sm"></i>
                                    {{ $product->auction->bids()->count() }} bids
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $products->links() }}
        </div>
    </section>
</x-app-layout>
