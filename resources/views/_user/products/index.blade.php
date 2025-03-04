<x-app-layout>
    <!-- Breadcrumb -->
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'My Artworks']
        ]
    ])

    <!-- Main Section -->
    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">My Artworks</h3>

            <a href="{{ route('products.create') }}"
                class="btn btn-purple w-auto rounded-xl px-3 py-1.5 shadow-lg">
                <i class="ri-add-circle-line text-xl"></i>
                <span>New Artwork</span>
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
        <div class="grid w-full gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($products as $product)
                <div class="relative flex max-w-sm flex-col overflow-hidden rounded-xl bg-purple-900 shadow-md transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                    
                    <!-- Clickable Overlay -->
                    <a href="{{ route('products.show', $product) }}" class="absolute left-0 top-0 z-20 h-full w-full">&nbsp;</a>

                    <!-- Artwork Image -->
                    <div class="h-auto overflow-hidden">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ asset($product->images) }}" alt="">
                        </div>
                    </div>

                    <!-- Artwork Details -->
                    <div class="p-3 px-4 text-purple-100">
                        <h3 class="font-bold text-yellow-300">
                            {{ $product->name }}
                        </h3>

                        <div class="mb-3 flex flex-col justify-between">
                            <p class="line-clamp-5 text-xs text-purple-300">
                                {{ $product->attributes['year'] }} • {{ $product->attributes['type'] }}
                            </p>
                            <p class="line-clamp-5 text-xs text-purple-300">
                                {{ $product->attributes['size'] }}
                            </p>
                        </div>

                        <!-- Price and Action -->
                        <div class="flex items-center justify-between align-middle">
                            <p class="text-sm font-semibold text-yellow-200">
                                ₱{{ $product->price }}
                            </p>

                            {{-- <div class="relative z-40 flex items-center gap-2">
                                <a href="" class="z-30 hover:text-yellow-300">
                                    <i class="ri-heart-line text-2xl"></i>
                                    {{ $product->bids()->count() }}
                                </a>
                            </div> --}}
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
