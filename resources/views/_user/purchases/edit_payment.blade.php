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

        <!-- Error Message -->
        @if(session('error'))
            <div class="flex items-center rounded-lg border-2 border-fuchsia-400 bg-fuchsia-100 p-3 py-2">
                <i class="ri-error-warning-line text-2xl text-fuchsia-600"></i>
                <span class="ml-2 text-sm font-semibold text-fuchsia-700">{{ session('error') }}</span>
            </div>
        @endif

        <div
            class="mx-auto w-full max-w-xl rounded-xl bg-gradient-to-br from-purple-500 via-pink-400 to-yellow-400 p-6 shadow-lg">
            <div class="mb-3 rounded-lg p-1 text-center">
                <h2 class="text-xl font-bold text-white">Confirm Payment</h2>
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
                        @if($purchase->purchasable instanceof \App\Models\Product)
                            <span class="font-semibold text-purple-800">
                                <i class="ri-store-line mr-2 text-pink-600"></i>Source: Direct Purchase
                            </span>
                        @elseif($purchase->purchasable instanceof \App\Models\ProductAuction)
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
                <p class="text-2xl font-semibold text-pink-600">
                    ₱{{ number_format($purchase->amount, 2) }}
                </p>
            </div>

            @if ($purchase->status === 'pending')
                <!-- Purchase Form -->
                <form method="POST" action="{{ route('purchases.update.payment', $purchase->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

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
                                onclick="return confirm('Are you sure you want to confirm the payment?');">
                            <i class="ri-check-line mr-2 text-base"></i> Confirm Payment
                        </button>
                    </div>
                </form>
            @elseif ($purchase->status === 'requested')
                <!-- Waiting for Seller Confirmation -->
                <div class="flex flex-col items-center justify-center pt-5">
                    <div class="flex w-full flex-col items-center justify-center space-y-4 rounded-lg border-2 border-dotted border-white/60 bg-white/5 p-6 text-center backdrop-blur-sm">
                        <p class="flex items-center gap-2 text-lg font-semibold text-white">
                            <i class="ri-information-line text-2xl text-yellow-300"></i>
                            Seller hasn't confirmed the purchase yet.
                        </p>
            
                        <form method="POST" action="{{ route('purchases.destroy', $purchase->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-white rounded-full font-bold"
                                    onclick="return confirm('Are you sure you want to cancel this purchase?');">
                                <i class="ri-close-line mr-2 text-base"></i> Cancel Purchase
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Purchase/Payment Already Completed -->
                <div class="flex flex-col items-center justify-center">
                    <div class="flex w-full flex-col items-center justify-center space-y-4 rounded-lg border-2 border-dotted border-purple-700 bg-white bg-opacity-40 p-6 text-center backdrop-blur-sm">
                        <p class="flex items-center gap-2 font-semibold text-purple-700">
                            <i class="ri-check-double-line text-2xl"></i>
                            This purchase has already been paid.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
