<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
        <!-- Profile Header -->
        <div class="rounded-xl bg-gradient-to-r from-purple-600 via-pink-500 to-purple-600 p-6 text-white shadow-lg">
            <div class="flex items-center gap-4">
                <img class="h-16 w-16 rounded-full border-4 border-white" src="{{ asset($user->profile_photo_path) }}" alt="{{ $user->name }}">
                <div>
                    <h1 class="text-2xl font-semibold">{{ $user->name }}</h1>
                    <p class="text-sm">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="mt-5 rounded-xl bg-white p-4 px-6 shadow-lg">
            <h2 class="text-xl font-semibold text-gray-800">Additional Info</h2>
            <div class="mt-2 grid grid-cols-1 gap-4 lg:grid-cols-3">
                <div>
                    <strong class="text-sm text-gray-600">Birthdate:</strong>
                    <p class="text-sm text-gray-800">
                        {{ $user->info->birthdate ? $user->info->birthdate->format('F j, Y') : 'Not Provided' }}
                    </p>
                </div>                
                <div>
                    <strong class="text-sm text-gray-600">Contact:</strong>
                    <p class="text-sm text-gray-800">{{ $user->info->contact ?? 'Not Provided' }}</p>
                </div>
                <div>
                    <strong class="text-sm text-gray-600">Address:</strong>
                    <p class="text-sm text-gray-800">{{ $user->info->address ?? 'Not Provided' }}</p>
                </div>
            </div>
        </div>

        <!-- User Products -->
        <div class="mt-5 rounded-xl bg-white p-6 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-900">Products</h2>

            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($user->products as $product)
                    <div class="group relative rounded-lg border border-gray-200 bg-gray-50 p-3 shadow-sm transition hover:shadow-md">
                        {{-- Product Image --}}
                        @if($product->images)
                            <img src="{{ asset($product->images) }}" alt="{{ $product->name }}" class="mb-2 h-28 w-full rounded-md object-cover">
                        @else
                            <div class="mb-2 flex h-28 w-full items-center justify-center rounded-md bg-gray-200 text-xs text-gray-500">
                                No Image
                            </div>
                        @endif
                    
                        {{-- Product Name --}}
                        <h3 class="truncate text-sm font-semibold text-gray-800">{{ $product->name }}</h3>
                    
                        {{-- Price and Attributes --}}
                        <div class="mt-1 space-y-0.5 text-xs text-gray-600">
                            @if($product->price)
                                <p><span class="font-medium text-gray-700">Price:</span> ${{ number_format($product->price, 2) }}</p>
                            @endif
                            @if(!empty($product->attributes['type']))
                                <p><span class="font-medium text-gray-700">Type:</span> {{ $product->attributes['type'] }}</p>
                            @endif
                            @if(!empty($product->attributes['size']))
                                <p><span class="font-medium text-gray-700">Size:</span> {{ $product->attributes['size'] }}</p>
                            @endif
                            @if(!empty($product->attributes['year']))
                                <p><span class="font-medium text-gray-700">Year:</span> {{ $product->attributes['year'] }}</p>
                            @endif
                        </div>
                    
                        {{-- Description --}}
                        @if($product->description)
                            <p class="mt-1 line-clamp-1 text-xs text-gray-500">{{ $product->description }}</p>
                        @endif
                    
                        {{-- View Button --}}
                        <div class="mt-3">
                            <a href="{{ route('products.show', $product->id) }}" class="block w-full rounded bg-purple-600 px-2.5 py-1 text-center text-xs font-semibold text-white hover:bg-purple-700">
                                View
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-2 text-center">
                <span class="inline-block animate-pulse text-lg font-bold text-purple-600">...</span>
            </div>
        </div>

        <!-- User Auctions -->
        <div class="mt-5 rounded-xl bg-white p-6 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-900">Auctions</h2>

            <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($user->auctions as $auction)
                    <div class="group relative rounded-lg border border-gray-200 bg-gray-50 p-4 shadow-sm transition hover:shadow-md">
                        {{-- Image --}}
                        @if($auction->product->images)
                            <img src="{{ asset($auction->product->images) }}" alt="{{ $auction->product->name }}" class="mb-3 h-28 w-full rounded-md object-cover">
                        @else
                            <div class="mb-3 flex h-28 w-full items-center justify-center rounded-md bg-gray-200 text-sm text-gray-500">
                                No Image
                            </div>
                        @endif

                        {{-- Title --}}
                        <h3 class="truncate text-base font-semibold text-gray-800">{{ $auction->product->name }}</h3>

                        {{-- Price & Status --}}
                        <div class="mt-1 flex items-center justify-between text-sm">
                            <span class="font-medium text-purple-600">${{ number_format($auction->price, 2) }}</span>
                            <span class="rounded bg-gray-100 px-2 py-0.5 text-xs text-gray-700">{{ ucfirst($auction->status) }}</span>
                        </div>

                        {{-- Dates --}}
                        <div class="mt-2 space-y-0.5 text-xs text-gray-500">
                            <p><strong>Start:</strong> {{ \Carbon\Carbon::parse($auction->start)->format('M d, Y h:i A') }}</p>
                            <p><strong>End:</strong> {{ \Carbon\Carbon::parse($auction->end)->format('M d, Y h:i A') }}</p>
                        </div>

                        {{-- View Button --}}
                        <div class="mt-3">
                            <a href="{{ route('auctions.show', $auction->id) }}" class="block w-full rounded bg-purple-600 px-3 py-1 text-center text-xs font-semibold text-white hover:bg-purple-700">
                                View
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-2 text-center">
                <span class="inline-block animate-pulse text-lg font-bold text-purple-600">...</span>
            </div>
        </div>

        <!-- User Purchases -->
        <div class="mt-5 rounded-xl bg-white p-6 shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-800">Purchases</h2>
            <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($user->purchases as $purchase)
                    <div class="rounded-lg border bg-purple-100 p-4">
                        <!-- Purchase Code -->
                        <div class="mb-2 font-semibold">
                            <p class="text-sm text-gray-800">#{{ $purchase->purchase_info['code'] }}</p>
                        </div>

                        <!-- Purchase Date -->
                        <div class="">
                            <p class="text-sm text-gray-700">{{ $purchase->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-1 text-center">
                <span class="inline-block animate-pulse text-xl font-bold text-purple-600">...</span>
            </div>
        </div>
    </div>
</x-app-layout>
