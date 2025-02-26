<x-app-layout>
    <!-- Breadcrumb -->
    <nav class="flex rounded-xl bg-purple-200 p-3 px-5 py-3 text-purple-900" aria-label="Breadcrumb">
        <ol class = "inline-flex items-center space-x-1 md:space-x-3">
            <li class = "inline-flex items-center">
                <a href="#" class="inline-flex items-center text-sm font-medium">
                    <i class="ri-home-4-fill mr-2 text-lg"></i>
                    Home
                </a>
            </li>
        </ol>
    </nav>

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
                    <a href="#" class="text-sm font-medium text-purple-500 hover:text-purple-800">
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
                    <a href="#" class="text-sm font-medium text-purple-500 hover:text-purple-800">
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
                    <a href="#" class="text-sm font-medium text-purple-500 hover:text-purple-800">
                        View all
                    </a>
                </div>
            </div>
            <div class="relative flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
                <div class="absolute mx-4 -mt-4 grid h-16 w-16 place-items-center overflow-hidden rounded-xl bg-gradient-to-tr from-orange-600 to-orange-400 bg-clip-border text-white shadow-lg shadow-orange-500/40">
                    <i class="ri-heart-fill text-2xl"></i>
                </div>
                <div class="p-4 text-right">
                    <p class="text-blue-gray-600 block font-sans text-sm font-normal leading-normal antialiased">Wishlist</p>
                    <h4 class="text-blue-gray-900 block font-sans text-2xl font-semibold leading-snug tracking-normal antialiased">123</h4>
                </div>
                <div class="border-blue-gray-50 mb-0 border-t p-2 text-center">
                    <a href="#" class="text-sm font-medium text-purple-500 hover:text-purple-800">
                        View all
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="relative flex flex-col justify-center overflow-hidden py-6">
        <div class="mx-auto w-full max-w-screen-xl px-1">
            <h3 class="my-4 text-2xl">Artworks Offered</h3>
            <div class="grid w-full gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($products as $product)
                    <div class="relative flex max-w-sm flex-col overflow-hidden rounded-xl bg-purple-900 shadow-md transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                        <a href="" class="absolute left-0 top-0 z-20 h-full w-full">&nbsp;</a>
                        <div class="h-auto overflow-hidden">
                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ asset($product->images) }}" alt="">
                            </div>
                        </div>
                        <div class="p-3 px-4 text-purple-100">
                            <h3 class="font-bold text-yellow-300">{{ $product->name }}</h3>
                            <div class="mb-3 flex items-center justify-between">
                                <p class="line-clamp-5 text-xs text-yellow-200">
                                    by: User Name
                                </p>
                            </div>

                            <div class="mb-3 flex flex-col justify-between">
                                <p class="line-clamp-5 text-xs text-purple-300">
                                    {{ $product->attributes['year'] }} • {{ $product->attributes['type'] }}
                                </p>
                                <p class="line-clamp-5 text-xs text-purple-300">
                                    {{ $product->attributes['size'] }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between align-middle">
                                <p class="text-sm font-semibold text-yellow-200">
                                    ₱{{ $product->price }}
                                </p>
                                <div class="relative z-40 flex items-center gap-2">
                                    <a href="" class="z-30 hover:text-yellow-300">
                                        <i class="ri-heart-line text-2xl"></i>
                                    </a>
                                </div>
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
