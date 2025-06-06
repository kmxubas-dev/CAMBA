<x-app-layout>
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'My Purchases', 'url' => route('purchases.index')],
            ['label' => 'Edit Purchase'],
        ]
    ])

    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">Edit Purchase</h3>

            <a href="{{ route('purchases.show', $purchase->id) }}"
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

        <!-- Receipt Container -->
        <div class="mx-auto w-full max-w-xl rounded-xl bg-white p-6 shadow-lg ring-2 ring-purple-300">
            <!-- Header Section -->
            <div class="mb-4 text-center">
                <h2 class="text-2xl font-semibold text-purple-950">{{ $purchase->product->name }}</h2>
                <p class="text-sm text-gray-500">Receipt #{{ $purchase->purchase_info['code'] }}</p>
            </div>

            <!-- Product Information Section -->
            <div class="mb-6 flex items-center gap-4 border-b-2 border-purple-300 pb-4">
                <img src="{{ asset($purchase->product->images) }}" 
                     alt="{{ $purchase->product->name }}" 
                     class="h-24 w-24 rounded-lg object-cover shadow-md ring-2 ring-purple-400" />
                <div class="text-left">
                    <p>
                        <i class="ri-user-line mr-2 text-pink-600"></i>
                        <a href="{{ route('custom.profile.show', $purchase->product->user->id) }}" 
                            class="font-medium text-purple-700 transition duration-150 ease-in-out hover:text-purple-900 hover:underline">
                            {{ $purchase->product->user->name }}
                        </a>
                    </p>
                    <p><i class="ri-expand-diagonal-line mr-2 text-pink-600"></i> {{ $purchase->product->attributes['size'] ?? '-' }}</p>
                    <p><i class="ri-calendar-line mr-2 text-pink-600"></i> {{ $purchase->product->attributes['year'] ?? '-' }}</p>
                    <p><i class="ri-palette-line mr-2 text-pink-600"></i> {{ $purchase->product->attributes['type'] ?? '-' }}</p>
                </div>
            </div>

            <!-- Total Section -->
            <div class="mb-6 text-center">
                <p class="text-sm text-gray-600">Total Paid</p>
                <p class="text-2xl font-semibold text-pink-600">₱{{ number_format($purchase->amount, 2) }}</p>
            </div>

            <!-- Payment Method & Status -->
            <div class="mb-4 border-t-2 border-purple-300 pt-4">
                <div class="flex items-center gap-3 text-gray-700">
                    <i class="ri-wallet-line text-xl text-pink-600"></i>
                    <p class="font-semibold">Payment Method:</p>
                    <p>{{ ucfirst(str_replace('_', ' ', $purchase->payment_info['method'])) }}</p>
                </div>
                <div class="mt-2 flex items-center gap-3 text-gray-700">
                    <i class="ri-check-line text-xl text-pink-600"></i>
                    <p class="font-semibold">Payment Status:</p>
                    <p>{{ ucfirst($purchase->payment_info['status']) }}</p>
                </div>
            </div>

            <!-- Purchase Status -->
            <div class="mb-6 border-t-2 border-purple-300 pt-4">
                <div class="flex items-center gap-3 text-gray-700">
                    <i class="ri-file-check-line text-xl text-pink-600"></i>
                    <p class="font-semibold">Purchase Status:</p>
                    <p>{{ ucfirst($purchase->status) }}</p>
                </div>
            </div>

            <!-- Purchase Source -->
            <div class="mb-6 flex items-center gap-4 border-t-2 border-purple-300 pt-4">
                @if ($purchase->purchasable_type === 'App\Models\Product')
                    <i class="ri-shopping-cart-2-line text-xl text-pink-600"></i>
                    <p><span class="font-semibold">Purchase Source:</span> Direct Purchase</p>
                @elseif ($purchase->purchasable_type === 'App\Models\ProductAuction')
                    <i class="ri-gift-line text-xl text-pink-600"></i>
                    <p><span class="font-semibold">Purchase Source:</span> Purchased via Auction</p>
                @endif
            </div>

            <!-- Date of Purchase -->
            <div class="text-center text-sm text-gray-600">
                <p><span class="font-semibold text-purple-900">Purchase Date:</span> {{ $purchase->created_at->format('F j, Y - g:i A') }}</p>
            </div>

            <!-- Edit Status Form -->
            <form method="POST" action="{{ route('purchases.update', $purchase->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Status Dropdown -->
                <div>
                    <label for="status" class="mb-1 block text-sm font-semibold text-purple-950">Update Purchase Status</label>
                    <select id="status" name="status" class="w-full rounded-lg border-2 border-purple-300 px-4 py-2 text-sm text-purple-900 focus:border-purple-500 focus:ring-2 focus:ring-purple-300" required>
                        <option value="" disabled {{ $purchase->status !== 'successful' ? 'selected' : '' }}>Select status</option>
                        <option value="successful" {{ $purchase->status === 'successful' ? 'selected' : '' }}>Received</option>
                    </select>

                    @error('status')
                        <p class="mt-2 text-center text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit"
                            class="btn btn-pink-to-purple rounded-full font-bold shadow-lg"
                            onclick="return confirm('Are you sure you want to update the purchase status?');">
                        <i class="ri-check-line mr-2 text-base"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
