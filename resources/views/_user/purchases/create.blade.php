<x-app-layout>
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'Artworks', 'url' => route('products.index')],
            ['label' => $product->name, 'url' => route('products.show', $product)],
            ['label' => 'Purchase']
        ]
    ])

    <!-- Main Section -->
    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">Purchase Artwork</h3>

            <a href="{{ route('products.show', $product->id) }}"
               class="btn btn-purple w-auto rounded-xl px-3 py-1.5 shadow-lg">
                <i class="ri-arrow-left-line text-xl"></i>
                <span>Back</span>
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="flex items-center rounded-lg border-2 border-purple-400 bg-purple-200 p-3 py-2">
                <i class="ri-check-line text-2xl text-purple-600"></i>
                <span class="ml-2 text-sm font-semibold text-fuchsia-600">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="flex items-center rounded-lg border-2 border-fuchsia-400 bg-fuchsia-100 p-3 py-2">
                <i class="ri-error-warning-line text-2xl text-fuchsia-600"></i>
                <span class="ml-2 text-sm font-semibold text-fuchsia-700">{{ session('error') }}</span>
            </div>
        @endif

        <div
            class="mx-auto w-full max-w-xl rounded-xl bg-gradient-to-br from-purple-500 via-pink-400 to-yellow-300 p-6 shadow-lg">
            <div class="mb-3 rounded-lg p-1 text-center">
                <h2 class="text-xl font-bold text-white">Confirm Purchase</h2>
            </div>

            <div
                class="mb-3 flex items-center gap-4 rounded-lg bg-white bg-opacity-50 p-4 shadow-lg backdrop-blur-md">
                <img src="{{ asset($product->images) }}" alt="{{ $product->name }}"
                     class="h-20 w-20 rounded-lg object-cover shadow-lg ring-2 ring-purple-400"/>
                <div class="text-sm text-gray-800">
                    <h3 class="text-lg font-semibold text-purple-950">{{ $product->name }}</h3>
                    <p><i class="ri-expand-diagonal-line mr-2 text-pink-600"></i>{{ $product->attributes['size'] }}</p>
                    <p><i class="ri-calendar-line mr-2 text-pink-600"></i>{{ $product->attributes['year'] }}</p>
                    <p><i class="ri-palette-line mr-2 text-pink-600"></i>{{ $product->attributes['type'] }}</p>
                    
                    <!-- Display purchase source -->
                    <p class="text-sm text-gray-600">
                        @if($purchasable_type === 'products')
                            <span class="font-semibold text-purple-800">
                                <i class="ri-store-line mr-2 text-pink-600"></i>Source: Direct Purchase
                            </span>
                        @elseif($purchasable_type === 'product_auctions')
                            <span class="font-semibold text-purple-800">
                                <i class="ri-auction-line mr-2 text-pink-600"></i>Source: Auction
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <div
                class="mb-4 rounded-md bg-white bg-opacity-80 px-6 py-3 text-center shadow-lg ring-1 ring-purple-300 backdrop-blur-md">
                <p class="text-sm text-gray-600">Total</p>
                @php
                    $total = $purchasable_type === 'product_auctions'
                        ? ($product->bids->max('amount') ?? 0)
                        : $product->price;
                @endphp

                <p class="text-2xl font-semibold text-pink-600">₱{{ number_format($total, 2) }}</p>
            </div>

            {{-- Purchase Form --}}
            <form method="POST" action="{{ route('purchases.store') }}" class="space-y-6">
                @csrf
            
                <input type="hidden" name="type" value="{{ $purchasable_type }}">
                <input type="hidden" name="id" value="{{ $purchasable_id }}">
            
                <!-- Payment Methods -->
                <div class="rounded-md">
                    <h4 class="mb-3 text-center text-lg font-semibold text-white">Choose Payment Method</h4>
                    <div class="grid grid-cols-3 gap-4">
                        @php
                            $methods = [
                                'gcash' => 'GCash',
                                'grab_pay' => 'GrabPay',
                                // 'maya' => 'Maya',
                                'cod' => 'Cash on Delivery',
                            ];
                        @endphp

                        @foreach ($methods as $value => $label)
                            <label
                                class="group relative flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-transparent bg-white bg-opacity-80 px-4 py-6 text-center text-sm font-medium text-purple-800 shadow-lg backdrop-blur-md transition-all duration-300 hover:border-purple-600 hover:bg-purple-50 hover:ring-2 hover:ring-purple-300 peer-checked:border-purple-600 peer-checked:ring-2 peer-checked:ring-purple-400">
                                <input type="radio" name="payment_method" value="{{ $value }}"
                                       class="peer hidden" required>
                                <div class="flex flex-col items-center gap-2 peer-checked:font-semibold peer-checked:text-purple-700">
                                    <i class="ri-wallet-line text-xl peer-checked:text-purple-700"></i>
                                    {{ $label }}
                                </div>
                                <div
                                    class="pointer-events-none absolute inset-0 rounded-lg border-2 border-transparent transition-all peer-checked:border-purple-700 peer-checked:ring-2 peer-checked:ring-purple-400"></div>
                            </label>
                        @endforeach
                    </div>
            
                    @error('payment_method')
                        <p class="mt-2 text-center text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            
                <div class="flex justify-center">
                    <button type="submit"
                            class="btn btn-pink-to-purple rounded-full font-bold shadow-lg"
                            onclick="return confirm('Are you sure you want to submit the purchase?');">
                        <i class="ri-check-line mr-2 text-base"></i> Confirm Purchase
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
