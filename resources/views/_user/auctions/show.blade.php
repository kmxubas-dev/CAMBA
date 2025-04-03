<x-app-layout>
    <!-- Breadcrumb -->
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'My Auctions', 'url' => route('auctions.index')],
            ['label' => $auction->product->name]
        ]
    ])

    <!-- Main Section -->
    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">Auction for: <span class="font-semibold text-purple-700">{{ $auction->product->name }}</span></h3>

            <a href="{{ route('auctions.index') }}"
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

        <!-- Main Auction Card -->
        <div class="relative flex flex-col gap-6 rounded-xl bg-gradient-to-tl from-purple-400 to-pink-400 p-6 shadow-lg">
            <!-- Two-column Layout -->
            <div class="flex flex-col gap-6 lg:flex-row">
                <!-- Auction Info (Left Column) -->
                <div class="w-full rounded-xl bg-white bg-opacity-50 p-3 shadow-md backdrop-blur-md sm:p-4 lg:w-1/2">
                    <!-- Product Image -->
                    <div class="relative mb-3 w-full cursor-pointer overflow-hidden rounded-2xl border-4 border-purple-200 bg-white shadow-md transition-all duration-300 ease-in-out hover:scale-[1.01] hover:shadow-lg">
                        <img src="{{ asset($auction->product->images) }}"
                            alt="{{ $auction->product->name }}"
                            class="h-64 w-full object-cover transition-transform duration-300 ease-in-out hover:scale-105 sm:h-[280px] lg:h-[320px]"
                            onclick="openModal('{{ asset($auction->product->images) }}')"
                            loading="lazy" />
                    </div>

                    <!-- Product Name -->
                    <div class="mb-2">
                        <h2 class="w-full rounded-xl bg-blue-50 px-3 py-1.5 text-xl font-bold tracking-tight text-purple-900 shadow-inner backdrop-blur-md sm:text-2xl">
                            <span class="bg-gradient-to-r from-purple-600 via-purple-500 to-purple-400 bg-clip-text text-transparent">
                                {{ $auction->product->name }}
                            </span>
                        </h2>
                    </div>

                    <!-- Auction Info Section with Countdown -->
                    <div class="mb-4">
                        <h4 class="mb-2 flex items-center gap-2 border-b pb-1 text-sm font-semibold text-purple-800">
                            <i class="ri-information-line text-lg text-purple-600"></i>
                            Auction Details
                        </h4>
                        <div class="grid grid-cols-2 gap-2 text-xs sm:grid-cols-3">
                            <!-- Status -->
                            <div class="flex flex-col items-center rounded bg-white/90 px-3 py-1.5 text-center shadow">
                                <i class="ri-auction-line mb-0.5 text-lg text-indigo-400"></i>
                                <p class="font-medium text-purple-600">Status</p>
                                <p class="text-sm font-bold text-purple-800">{{ ucfirst($auction->status) }}</p>
                            </div>

                            <!-- Start Price -->
                            <div class="flex flex-col items-center rounded bg-white/90 px-3 py-1.5 text-center shadow">
                                <i class="ri-price-tag-3-line mb-0.5 text-lg text-indigo-400"></i>
                                <p class="font-medium text-purple-600">Start Price</p>
                                <p class="text-sm font-bold text-purple-800">₱{{ number_format($auction->price, 2) }}</p>
                            </div>

                            <!-- Winning Bid -->
                            <div class="flex flex-col items-center rounded bg-white/90 px-3 py-1.5 text-center shadow">
                                <i class="ri-currency-line mb-0.5 text-lg text-indigo-400"></i>
                                <p class="font-medium text-purple-600">Winning Bid</p>
                                <p class="text-sm font-bold text-purple-800">
                                    ₱{{ number_format($auction->bids->max('amount') ?? $auction->price, 2) }}
                                </p>
                            </div>

                            <!-- Start Date -->
                            <div class="flex flex-col items-center rounded bg-white/90 px-3 py-1.5 text-center shadow">
                                <i class="ri-calendar-line mb-0.5 text-lg text-indigo-400"></i>
                                <p class="font-medium text-purple-600">Start Date</p>
                                <p class="text-sm font-bold text-purple-800">{{ $auction->start->format('M d, Y') }}</p>
                                <p class="text-sm font-bold text-purple-800">{{ $auction->start->format('h:i A') }}</p>
                            </div>

                            <!-- Countdown Timer -->
                            <div class="flex flex-col items-center rounded bg-white/90 px-3 py-1.5 text-center shadow">
                                <i class="ri-time-line mb-0.5 text-lg text-indigo-400"></i>
                                <p class="font-medium text-purple-600">Time Left</p>
                                <div id="countdown-timer" class="mt-0.5 text-base font-bold text-pink-600">--:--</div>
                            </div>

                            <!-- End Date -->
                            <div class="flex flex-col items-center rounded bg-white/90 px-3 py-1.5 text-center shadow">
                                <i class="ri-calendar-event-line mb-0.5 text-lg text-indigo-400"></i>
                                <p class="font-medium text-purple-600">End Date</p>
                                <p class="text-sm font-bold text-purple-800">{{ $auction->end->format('M d, Y') }}</p>
                                <p class="text-sm font-bold text-purple-800">{{ $auction->end->format('h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info Section -->
                    <div class="mb-1">
                        <h4 class="mb-2 flex items-center gap-2 border-b pb-1 text-sm font-semibold text-purple-800">
                            <i class="ri-information-line text-lg text-purple-600"></i>
                            Product Info
                        </h4>

                        <!-- Type, Size, Year -->
                        <div class="rounded bg-white/80 p-3 shadow sm:flex sm:justify-between sm:gap-3">
                            <div class="sm:w-1/3">
                                <p class="text-xs font-medium uppercase text-purple-500">Type</p>
                                <p class="text-sm font-semibold text-purple-900">{{ $auction->product->attributes['type'] }}</p>
                            </div>
                            <div class="sm:w-1/3">
                                <p class="text-xs font-medium uppercase text-purple-500">Size</p>
                                <p class="text-sm font-semibold text-purple-900">{{ $auction->product->attributes['size'] }}</p>
                            </div>
                            <div class="sm:w-1/3">
                                <p class="text-xs font-medium uppercase text-purple-500">Year</p>
                                <p class="text-sm font-semibold text-purple-900">{{ $auction->product->attributes['year'] }}</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-2 rounded bg-white/80 p-3 shadow">
                            <p class="text-xs font-medium uppercase text-purple-500">Description</p>
                            <p class="text-sm leading-snug text-purple-800">
                                {{ Str::limit($auction->product->description, 100) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Bidding History -->
                <div class="w-full rounded-xl bg-white p-8 shadow-xl lg:w-1/2">
                    <h4 class="mb-6 text-xl font-semibold text-purple-800">Top 10 Bids</h4>
                    @if($auction->bids->count())
                        <ul class="divide-y divide-purple-100">
                            @foreach($bids_top10 as $index => $bid)
                                @php
                                    $placementClass = match($index) {
                                        0 => 'bg-yellow-500',
                                        1 => 'bg-gray-300',
                                        2 => 'bg-yellow-200',
                                        default => 'bg-purple-300'
                                    };
                                    $placementLabel = match($index) {
                                        0 => '1st',
                                        1 => '2nd',
                                        2 => '3rd',
                                        default => ($index + 1) . 'th'
                                    };
                                @endphp

                                <li class="flex items-center justify-between px-6 py-4 transition-all duration-300 ease-in-out hover:scale-105 hover:bg-purple-50 hover:shadow-md">
                                    <div class="flex w-full items-center space-x-6">
                                        <!-- Badge with fixed size and perfect circle -->
                                        <div class="font-semibold text-white rounded-full px-5 py-2 text-xs sm:text-sm {{ $placementClass }}">
                                            <span class="leading-tight">{{ $placementLabel }}</span>
                                        </div>
                                    
                                        <!-- Content: Name and Time -->
                                        <div class="flex w-full flex-col sm:flex-row sm:items-center sm:space-x-3">
                                            <div class="text-sm font-semibold text-gray-800">{{ $bid->user->name }}</div>
                                            <span class="mt-1 text-xs text-gray-500 sm:mt-0">{{ $bid->updated_at->diffForHumans() }}</span>
                                        </div>
                                    </div>                    
                                    
                                    <div class="ml-6 text-sm font-semibold text-purple-700">
                                        ₱{{ number_format($bid->amount, 2) }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-600">No bids placed yet.</p>
                    @endif
                </div>
            </div>

            <!-- Bottom Section: Image + Action Buttons -->
            <div class="grid w-full grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Action Buttons (Left Side) -->
                <div class="flex w-full flex-col justify-center gap-4 p-0">
                    <!-- My Auctions (Moved to the top) -->
                    <a href="{{ route('auctions.index') }}"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-white py-3 text-sm font-semibold text-purple-700 shadow-md transition hover:bg-purple-100">
                        <i class="ri-auction-line text-lg"></i>
                        <span>My Auctions</span>
                    </a>

                    <!-- Edit Auction (Moved to the left side) -->
                    <a href="{{ route('auctions.edit', $auction->id) }}"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-white py-3 text-sm font-semibold text-purple-700 shadow-md transition hover:bg-purple-100">
                        <i class="ri-edit-line text-lg"></i>
                        <span>Edit Auction</span>
                    </a>

                    <!-- View Artwork -->
                    <a href="{{ route('products.show', $auction->product->id) }}"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-white py-3 text-sm font-semibold text-purple-700 shadow-md transition hover:bg-purple-100">
                        <i class="ri-image-line text-lg"></i>
                        <span>View Artwork</span>
                    </a>
                </div>

                <!-- Action Buttons (Right Side) -->
                <div class="flex w-full flex-col justify-center gap-4 p-0">
                    <!-- Pause or Resume Button -->
                    <form action="{{ route('auctions.update', $auction->id) }}" method="POST"
                          onsubmit="{{ in_array($auction->status, ['ended', 'sold']) ? 'return false;' : 'return confirm(\'Are you sure you want to ' . ($auction->status === 'paused' ? 'resume' : 'pause') . ' this auction?\');' }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="{{ $auction->status === 'paused' ? 'active' : 'paused' }}">
                
                        <button type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-white py-3 text-sm font-semibold text-blue-600 shadow-md transition hover:bg-blue-100 disabled:cursor-not-allowed disabled:opacity-50"
                                {{ in_array($auction->status, ['ended', 'sold']) ? 'disabled' : '' }}>
                            <i class="ri-{{ $auction->status === 'paused' ? 'play' : 'pause' }}-line text-lg"></i>
                            <span>{{ $auction->status === 'paused' ? 'Resume' : 'Pause' }} Auction</span>
                        </button>
                    </form>
                
                    <!-- Finish Button (disabled when ended or sold) -->
                    <form action="{{ route('auctions.update', $auction->id) }}" method="POST"
                        onsubmit="{{ in_array($auction->status, ['ended', 'sold']) ? 'return false;' : 'return confirm(\'Are you sure you want to finish this auction?\');' }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="ended">
                        <input type="hidden" name="end" value="{{ now()->setSeconds(0) }}">
                    
                        <button type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-white py-3 text-sm font-semibold text-green-600 shadow-md transition hover:bg-green-100 disabled:cursor-not-allowed disabled:opacity-50"
                                {{ in_array($auction->status, ['ended', 'sold']) ? 'disabled' : '' }}>
                            <i class="ri-check-line text-lg"></i>
                            <span>Finish Auction</span>
                        </button>
                    </form>                  
                
                    <!-- Stop Button -->
                    <form action="{{ route('auctions.destroy', $auction) }}" method="POST"
                        onsubmit="return {{ $auction->status === 'sold' ? 'false' : 'confirm(\'Are you sure you want to delete this auction?\')' }};">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-white py-3 text-sm font-semibold text-red-600 shadow-md transition hover:bg-red-100 disabled:cursor-not-allowed disabled:opacity-50"
                                {{ $auction->status === 'sold' ? 'disabled' : '' }}>
                            <i class="ri-delete-bin-line text-lg"></i>
                            <span>Stop Auction</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Full Image Viewer -->
    <div id="imageModal"
         class="fixed inset-0 z-50 hidden items-center justify-center overflow-auto bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 ease-in-out">
        <div class="relative mx-auto max-h-[90vh] w-full max-w-4xl scale-95 transform rounded-lg bg-gradient-to-tl from-purple-50 via-pink-50 to-yellow-50 p-6 opacity-100 shadow-lg transition-all duration-500 ease-in-out">
            
            <!-- Close Modal Button -->
            <button onclick="closeModal()"
                    class="absolute right-4 top-4 flex h-12 w-12 items-center justify-center rounded-full bg-purple-600 text-white shadow-lg transition duration-300 hover:bg-purple-700 focus:outline-none"
                    aria-label="Close Modal">
                <i class="ri-close-line text-2xl"></i>
            </button>

            <!-- Modal Image -->
            <img id="modalImage" src="" alt="Full Image"
                 class="h-auto max-h-[80vh] w-full rounded-lg border-4 border-yellow-300 object-contain shadow-md"/>
        </div>
    </div>

    @section('scripts')
        <script>
            const countdownTimer = document.getElementById("countdown-timer");
            let timeLeft = {{ $timeRemaining }} * 1000; // assuming $timeRemaining is in seconds

            function updateCountdown() {
                if (timeLeft <= 0) {
                    countdownTimer.innerText = "Auction Ended";
                    return;
                }
                timeLeft -= 1000; // reduce by one second

                let hours = Math.floor(timeLeft / (1000 * 60 * 60));
                let mins = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                let secs = Math.floor((timeLeft % (1000 * 60)) / 1000);

                countdownTimer.innerText = `${String(hours).padStart(2, '0')}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();

            // Modal logic
            function openModal(imageSrc) {
                const modal = document.getElementById('imageModal');
                modal.style.display = 'flex';
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100', 'scale-100');
                document.getElementById('modalImage').src = imageSrc;
            }

            function closeModal() {
                const modal = document.getElementById('imageModal');
                modal.classList.remove('opacity-100', 'scale-100');
                modal.classList.add('opacity-0');
                setTimeout(() => modal.style.display = 'none', 300);
            }
        </script>
    @endsection
</x-app-layout>
