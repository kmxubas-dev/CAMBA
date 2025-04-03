<x-app-layout>
    <!-- Breadcrumb -->
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'My Auctions', 'url' => route('auctions.index')],
            ['label' => 'Edit Auction']
        ]
    ])

    <!-- Main Section -->
    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h3 class="text-xl sm:text-2xl">
                Edit Auction for: 
                <span class="font-semibold text-purple-700">{{ $auction->product->name }}</span>
            </h3>

            <a href="{{ route('auctions.index') }}" class="btn btn-purple rounded-xl px-3 py-1.5 shadow-lg">
                <i class="ri-arrow-left-line text-xl"></i>
                <span>My Auctions</span>
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 flex items-center rounded-lg border-2 border-purple-400 bg-purple-200 p-3">
                <i class="ri-check-line text-2xl text-purple-600"></i>
                <span class="ml-2 text-sm font-semibold text-fuchsia-600">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Edit Card -->
        <div class="rounded-xl bg-gradient-to-tl from-purple-400 to-pink-400 p-6 shadow-lg">
            <div class="flex flex-col gap-6 xl:flex-row">
                <!-- Left: Product Info -->
                <div class="w-full space-y-5 rounded-xl bg-white/60 p-6 shadow-xl ring-1 ring-purple-200 backdrop-blur-md transition-all duration-300 hover:shadow-2xl xl:w-1/2">
                    <!-- Product Image -->
                    <div class="overflow-hidden rounded-xl border-4 border-purple-300 shadow-lg transition-transform hover:scale-[1.02] hover:shadow-xl">
                        <img 
                            src="{{ asset($auction->product->images) }}"
                            alt="{{ $auction->product->name }}"
                            class="h-72 w-full object-cover transition-transform duration-300 ease-in-out hover:scale-105"
                        />
                    </div>

                    <!-- Product Info -->
                    <div class="space-y-5 text-purple-900">
                        <h3 class="bg-gradient-to-r from-purple-700 via-pink-600 to-yellow-400 bg-clip-text text-2xl font-extrabold leading-snug text-transparent drop-shadow">
                            {{ $auction->product->name }}
                        </h3>

                        <div class="grid grid-cols-1 gap-4 text-sm font-medium sm:grid-cols-3">
                            @foreach (['type', 'size', 'year'] as $attr)
                                <div class="rounded-md bg-purple-50 px-4 py-2 shadow-sm">
                                    <p class="flex items-center gap-1 text-xs font-bold uppercase text-purple-500">
                                        <i class="ri-{{ $attr === 'type' ? 'brush' : ($attr === 'size' ? 'aspect-ratio' : 'calendar-2') }}-line text-purple-400"></i> 
                                        {{ ucfirst($attr) }}
                                    </p>
                                    <p class="mt-1 text-sm font-semibold text-purple-800">
                                        {{ $auction->product->attributes[$attr] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <div class="rounded-md bg-purple-50 px-4 py-3 shadow-sm">
                            <p class="mb-1 flex items-center gap-2 text-xs font-bold uppercase text-purple-500">
                                <i class="ri-information-line text-purple-400"></i> Description
                            </p>
                            <p class="text-sm leading-relaxed text-purple-800">
                                {{ $auction->product->description }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right: Edit Form -->
                <div class="w-full rounded-lg bg-white/60 p-8 shadow-lg backdrop-blur-md xl:w-1/2">
                    <!-- Form Title -->
                    <div class="mb-4 flex items-center">
                        <hr class="flex-grow border-t-2 border-purple-500">
                        <span class="mx-4 text-sm font-semibold uppercase text-purple-800">Auction Details</span>
                        <hr class="flex-grow border-t-2 border-purple-500">
                    </div>

                    @php
                        $statusIcons = [
                            'active' => 'ri-play-line',
                            'paused' => 'ri-pause-line',
                            'ended'  => 'ri-checkbox-circle-line',
                            'sold'   => 'ri-shopping-cart-2-line',
                        ];
                    @endphp

                    <!-- Status -->
                    <div class="mb-5 flex items-center justify-center gap-3 rounded-md border border-purple-300 bg-white/90 px-6 py-2 font-medium text-purple-800 shadow-lg">
                        <i class="{{ $statusIcons[$auction->status] ?? 'ri-information-line' }} text-xl opacity-80"></i>
                        <span>Status: <strong class="font-semibold">{{ ucfirst($auction->status) }}</strong></span>
                    </div>

                    <!-- Disabled Notice -->
                    @if(in_array($auction->status, ['ended', 'sold']))
                        <div class="mb-4 rounded-md border border-gray-300 bg-gray-50 p-3 text-center text-sm font-medium text-gray-600 shadow-sm">
                            <i class="ri-lock-line mr-1 align-middle text-base text-gray-500"></i>
                            Editing is disabled because this auction has <strong>{{ $auction->status }}</strong>.
                        </div>
                    @endif

                    <!-- Edit Form -->
                    <div class="{{ in_array($auction->status, ['ended', 'sold']) ? 'opacity-60 pointer-events-none' : '' }}">
                        <form 
                            action="{{ route('auctions.update', $auction) }}" 
                            method="POST" 
                            class="space-y-4"
                            @if(in_array($auction->status, ['ended', 'sold'])) onsubmit="return false;" @endif
                        >
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                @foreach (['start', 'end'] as $field)
                                    <div>
                                        <label for="{{ $field }}" class="block text-sm font-medium text-purple-800">
                                            {{ ucfirst($field) }} date & time
                                        </label>
                                        <input 
                                            type="datetime-local" 
                                            name="{{ $field }}" 
                                            id="{{ $field }}" 
                                            value="{{ old($field, $auction->$field) }}"
                                            class="mt-1 w-full rounded-md border {{ $errors->has($field) ? 'border-red-500' : 'border-purple-300' }} p-2 px-3 text-sm text-purple-900 shadow-sm {{ in_array($auction->status, ['ended', 'sold']) ? 'cursor-not-allowed bg-gray-100' : '' }}"
                                        >
                                        @error($field)
                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <!-- Starting Price -->
                            <div>
                                <label for="price" class="text-sm font-medium text-purple-800">Starting price (₱)</label>
                                <input 
                                    type="number" 
                                    name="price" 
                                    id="price" 
                                    step="0.0001" 
                                    min="0" 
                                    value="{{ old('price', $auction->price) }}"
                                    class="mt-1 w-full rounded-md border {{ $errors->has('price') ? 'border-red-500' : 'border-purple-300' }} p-2 px-3 text-sm text-purple-900 shadow-sm {{ in_array($auction->status, ['ended', 'sold']) ? 'cursor-not-allowed bg-gray-100' : '' }}"
                                >
                                @error('price')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Save -->
                            <div class="pt-2">
                                <button 
                                    type="submit" 
                                    class="btn btn-purple w-full rounded-full py-1 {{ in_array($auction->status, ['ended', 'sold']) ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ in_array($auction->status, ['ended', 'sold']) ? 'disabled' : '' }}
                                >
                                    <i class="ri-save-line text-lg"></i> <span>Save</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- View / Cancel Buttons -->
                    <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2">
                        <a href="{{ route('auctions.show', $auction) }}" class="btn btn-outline-purple rounded-full py-1 text-center">
                            <i class="ri-close-line text-lg"></i> Cancel
                        </a>
                        <a href="{{ route('products.show', $auction->product) }}" class="btn btn-white w-full rounded-full py-1 text-center">
                            <i class="ri-eye-line text-lg"></i> View Product
                        </a>
                    </div>

                    <!-- Action Options -->
                    <div class="mb-5 mt-8 flex items-center">
                        <hr class="flex-grow border-t-2 border-purple-500">
                        <span class="mx-4 text-sm font-semibold uppercase text-purple-800">Action Options</span>
                        <hr class="flex-grow border-t-2 border-purple-500">
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
                        @if (in_array($auction->status, ['active', 'paused', 'ended']))
                            <form method="POST" action="{{ route('auctions.update', $auction->id) }}" onsubmit="return confirm('Are you sure you want to restart this auction?')">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action_type" value="restart">
                                <input type="hidden" name="status" value="active">
                                <input type="hidden" name="start" value="{{ now()->setSeconds(0) }}">
                                <input type="hidden" name="end" value="{{ now()->addDay()->setSeconds(0) }}">
                                <input type="hidden" name="price" value="{{ $auction->product->price }}">
                                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-md border border-purple-300 bg-purple-100 px-4 py-2 text-purple-800 shadow-sm transition duration-300 hover:bg-purple-200">
                                    <i class="ri-refresh-line text-lg"></i> Restart Auction
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('auctions.update', $auction->id) }}" onsubmit="return confirm('Are you sure you want to end this auction?')">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="ended">
                            <input type="hidden" name="end" value="{{ now()->setSeconds(0) }}">
                            <button type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-md border border-purple-300 bg-purple-100 px-4 py-2 text-purple-800 shadow-sm transition duration-300 hover:bg-purple-200 disabled:cursor-not-allowed disabled:opacity-50"
                                {{ $auction->status === 'ended' ? 'disabled' : '' }}>
                                <i class="ri-check-line text-lg"></i> End Auction
                            </button>
                        </form>                        

                        <form method="POST" action="{{ route('auctions.destroy', $auction->id) }}" onsubmit="return confirm('Are you sure you want to stop this auction?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-md border border-red-300 bg-red-100 px-4 py-2 text-red-700 shadow-sm transition duration-300 hover:bg-red-200">
                                <i class="ri-close-line text-lg"></i> Stop Auction
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
