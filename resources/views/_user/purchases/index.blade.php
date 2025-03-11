<x-app-layout>
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'My Purchases']
        ]
    ])

    <!-- Main Section -->
    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">My Purchases</h3>

            {{-- <a href="{{ route('purchases.create') }}"
                class="btn btn-purple w-auto rounded-xl px-3 py-1.5 shadow-lg">
                <i class="ri-add-circle-line text-xl"></i>
                <span>Purchase</span>
            </a> --}}
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

        <!-- Purchases List -->
        @if($purchases->isEmpty())
            <div class="flex items-center justify-center py-10">
                <div class="text-center text-gray-600">
                    <i class="ri-shopping-bag-line mb-6 text-4xl text-gray-400"></i>
                    <h4 class="text-xl font-semibold">You haven't made any purchases yet!</h4>
                    <p class="mt-2 text-base">Browse our products and start shopping to see your purchase history here.</p>
                    <a href="{{ route('products.index') }}" class="mt-6 inline-block rounded-xl bg-gradient-to-r from-purple-600 to-pink-500 px-6 py-2 text-base text-white transition duration-300 hover:bg-purple-700">
                        Start Shopping
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-2">
                @foreach ($purchases as $purchase)
                    <div class="flex w-full transform flex-col items-center justify-between gap-4 rounded-md border bg-white p-4 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl lg:flex-row lg:gap-6">
                        <!-- Product Info (Image + Name + Date) -->
                        <div class="flex w-full items-center gap-3 lg:w-3/12">
                            <img src="{{ asset($purchase->product->images) }}" alt="{{ $purchase->product->name }}" class="h-16 w-16 transform rounded-md object-cover transition duration-200 hover:translate-x-1" />
                            <div>
                                <h4 class="text-sm font-semibold transition duration-200 hover:text-purple-600">{{ $purchase->product->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $purchase->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Purchase Info (Code + Price) -->
                        <div class="w-full space-y-2 text-sm lg:w-3/12">
                            <!-- Code Section -->
                            <div>
                                <strong class="text-gray-800">Code:</strong>
                                <span class="font-semibold text-purple-700">{{ $purchase->purchase_info['code'] }}</span>
                            </div>
                            
                            <!-- Price Section -->
                            <div>
                                <strong class="text-gray-800">Price:</strong>
                                <span class="font-semibold text-pink-600">₱{{ number_format($purchase->amount, 2) }}</span>
                            </div>
                        </div>

                        <!-- Status and View Button -->
                        <div class="flex w-full items-center justify-between text-center text-sm lg:w-3/12">
                            <!-- Status Badge -->
                            <div class="inline-block py-1 px-4 rounded-full text-xs font-medium uppercase 
                                {{ $purchase->status == 'Paid' ? 'bg-green-100 text-green-600' : 
                                   ($purchase->status == 'Pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-600') }}">
                                {{ ucfirst($purchase->status) }}
                            </div>

                            <!-- View Details Button -->
                            <div class="ml-4">
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-purple rounded-md px-3 py-1 text-xs font-semibold">
                                    <i class="ri-eye-line"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $purchases->links() }}
            </div>
        @endif
    </section>
</x-app-layout>
