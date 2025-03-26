<x-app-layout>
    <!-- Breadcrumb -->
    @include('partials.app_breadcrumbs')

    <!-- Stat Cards -->
    <div class="mt-10">
        <div class="grid gap-x-6 gap-y-8 md:grid-cols-2 xl:grid-cols-4">
            <div class="relative flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
                <div class="absolute mx-4 -mt-4 grid h-16 w-16 place-items-center overflow-hidden rounded-xl bg-gradient-to-tr from-blue-600 to-blue-400 bg-clip-border text-white shadow-lg shadow-blue-500/40">
                    <i class="ri-gallery-fill text-2xl"></i>
                </div>
                <div class="p-4 text-right">
                    <p class="text-blue-gray-600 block font-sans text-sm font-normal leading-normal antialiased">Artworks Posted</p>
                    <h4 class="text-blue-gray-900 block font-sans text-2xl font-semibold leading-snug tracking-normal antialiased">{{ $products_count }}</h4>
                </div>
                <div class="border-blue-gray-50 mb-0 border-t p-2 text-center">
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-purple-500 hover:text-purple-800">
                        View all
                    </a>
                </div>
            </div>
            <div class="relative flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
                <div class="absolute mx-4 -mt-4 grid h-16 w-16 place-items-center overflow-hidden rounded-xl bg-gradient-to-tr from-pink-600 to-pink-400 bg-clip-border text-white shadow-lg shadow-pink-500/40">
                    <i class="ri-auction-fill text-2xl"></i>
                </div>
                <div class="p-4 text-right">
                    <p class="text-blue-gray-600 block font-sans text-sm font-normal leading-normal antialiased">Auctions Started</p>
                    <h4 class="text-blue-gray-900 block font-sans text-2xl font-semibold leading-snug tracking-normal antialiased">{{ $auctions_count }}</h4>
                </div>
                <div class="border-blue-gray-50 mb-0 border-t p-2 text-center">
                    <a href="{{ route('auctions.index') }}" class="text-sm font-medium text-purple-500 hover:text-purple-800">
                        View all
                    </a>
                </div>
            </div>
            <div class="relative flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
                <div class="absolute mx-4 -mt-4 grid h-16 w-16 place-items-center overflow-hidden rounded-xl bg-gradient-to-tr from-green-600 to-green-400 bg-clip-border text-white shadow-lg shadow-green-500/40">
                    <i class="ri-hand-coin-fill text-2xl"></i>
                </div>
                <div class="p-4 text-right">
                    <p class="text-blue-gray-600 block font-sans text-sm font-normal leading-normal antialiased">Bids Made</p>
                    <h4 class="text-blue-gray-900 block font-sans text-2xl font-semibold leading-snug tracking-normal antialiased">{{ $bids_count }}</h4>
                </div>
                <div class="border-blue-gray-50 mb-0 border-t p-2 text-center">
                    <a href="{{ route('bids.index') }}" class="text-sm font-medium text-purple-500 hover:text-purple-800">
                        View all
                    </a>
                </div>
            </div>
            <div class="relative flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
                <div class="absolute mx-4 -mt-4 grid h-16 w-16 place-items-center overflow-hidden rounded-xl bg-gradient-to-tr from-orange-600 to-orange-400 bg-clip-border text-white shadow-lg shadow-orange-500/40">
                    <i class="ri-shopping-cart-fill text-2xl"></i>
                </div>
                <div class="p-4 text-right">
                    <p class="text-blue-gray-600 block font-sans text-sm font-normal leading-normal antialiased">Purchases</p>
                    <h4 class="text-blue-gray-900 block font-sans text-2xl font-semibold leading-snug tracking-normal antialiased">{{ $purchases_count }}</h4>
                </div>
                <div class="border-blue-gray-50 mb-0 border-t p-2 text-center">
                    <a href="{{ route('purchases.index') }}" class="text-sm font-medium text-purple-500 hover:text-purple-800">
                        View all
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="relative flex flex-col justify-center overflow-hidden py-6">
        <div class="mx-auto w-full max-w-screen-xl px-1">
            <h3 class="mb-3 text-2xl">Artworks Offered</h3>
            <div class="grid w-full gap-6 md:grid-cols-2 xl:grid-cols-4">
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
        </div>
    </div>
</x-app-layout>



{{-- <x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>
</x-app-layout> --}}
