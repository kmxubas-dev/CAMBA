<x-app-layout>
    <!-- Breadcrumb -->
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'My Auctions', 'url' => route('auctions.index')],
            ['label' => $auction->product->name]
        ]
    ])

    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">Auction for: <span class="font-semibold text-purple-700">{{ $auction->product->name }}</span></h3>

            <a href="{{ url()->previous() }}"
                class="btn btn-purple w-auto rounded-xl px-3 py-1.5 shadow-lg">
                <i class="ri-arrow-left-line text-xl"></i>
                <span>Back</span>
            </a>
        </div>

        <!-- Success & Error Messages -->
        @if(session('success'))
            <div class="flex items-center rounded-lg border-2 border-purple-400 bg-purple-200 p-3 py-2">
                <i class="ri-check-line text-2xl text-purple-600"></i>
                <span class="ml-2 text-sm font-semibold text-fuchsia-600">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center rounded-lg border-2 border-fuchsia-400 bg-fuchsia-100 p-3 py-2">
                <i class="ri-error-warning-line text-2xl text-fuchsia-600"></i>
                <span class="ml-2 text-sm font-semibold text-fuchsia-700">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Main Auction Card -->
        <div class="relative flex flex-col gap-6 rounded-xl bg-gradient-to-tl from-purple-400 to-pink-400 p-6 shadow-lg">
            <!-- Auction Info + Bid History -->
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

                <!-- Bidding Section (Right Column) -->
                <div class="w-full rounded-xl bg-white bg-opacity-60 p-5 shadow-lg backdrop-blur-lg sm:p-6 lg:flex lg:w-1/2 lg:flex-col">
                    <!-- Title -->
                    <h4 class="mb-4 flex items-center gap-3 text-xl font-semibold text-purple-800">
                        <i class="ri-auction-line text-2xl text-purple-600"></i>
                        <span>Place a Bid</span>
                    </h4>

                    <!-- Bid History -->
                    <div class="relative mx-auto mb-6 w-full">
                        @php
                            $topBids = $auction->bids->sortByDesc('amount')->take(4)->values()->reverse();
                            $currentHighest = $auction->bids->max('amount') ?? $auction->price;
                        @endphp

                        @foreach($topBids as $index => $bid)
                            @if($bid->amount != $currentHighest)
                                @php
                                    $opacity = 90 - ($index * 12);
                                    $scale = 1 - ($index * 0.05);
                                    $blur = $index * 0.2;
                                @endphp

                                <div class="mb-2 transition-all duration-300 ease-in-out"
                                    style="opacity: {{ $opacity / 100 }}; transform: scale({{ $scale }}); filter: blur({{ $blur }}px);">
                                    <div class="rounded-lg border border-purple-100 bg-purple-50 p-3 text-center shadow-sm">
                                        <p class="text-sm font-medium text-purple-700">₱{{ number_format($bid->amount, 2) }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <div class="z-10 mt-3 rounded-lg border border-purple-300 bg-gradient-to-r from-purple-100 via-white to-fuchsia-50 p-5 text-center shadow-lg ring-1 ring-fuchsia-300/30">
                            <p class="text-xs font-semibold uppercase tracking-wider text-purple-600 drop-shadow-sm">Current highest bid</p>
                            <p class="text-2xl font-extrabold text-purple-900 drop-shadow-sm">₱{{ number_format($currentHighest, 2) }}</p>

                            {{-- Winner Indicator if Auction Ended/Sold --}}
                            @if(in_array($auction->status, ['ended', 'sold']))
                                <p class="mt-2 inline-flex items-center justify-center gap-2 rounded-md bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 shadow-sm ring-1 ring-green-300">
                                    <i class="ri-medal-line text-base text-yellow-500"></i>
                                    Highest bid won this auction
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Check if user has already bidded -->
                    @php
                        $userBid = $auction->bids->where('user_id', auth()->id())->sortByDesc('amount')->first();
                        $isUserHighestBidder = $userBid && $userBid->amount == $currentHighest;
                    @endphp

                    <div class="relative mb-6 rounded-lg border border-purple-300 bg-gradient-to-br from-purple-200 via-fuchsia-100 to-purple-50 p-5 text-center">
                        @if($userBid)
                            <p class="mb-2 text-sm font-semibold text-purple-700">
                                Your current bid:
                            </p>
                            <p class="text-xl font-semibold text-purple-900">
                                ₱{{ number_format($userBid->amount, 2) }}
                            </p>

                            @if($userBid->amount == $currentHighest)
                                @if(in_array($auction->status, ['ended', 'sold']))
                                    <!-- Winner Badge -->
                                    <span class="absolute right-2 top-2 inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 shadow-sm ring-1 ring-green-300">
                                        <i class="ri-award-line animate-bounce text-base text-yellow-500"></i>
                                        You won this auction
                                    </span>
                                @else
                                    <!-- Highest Bid Badge (while auction still active) -->
                                    <span class="absolute right-2 top-2 inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 shadow-sm ring-1 ring-green-300">
                                        <i class="ri-trophy-line animate-pulse text-base text-yellow-500"></i>
                                        Highest Bid
                                    </span>
                                @endif
                            @endif
                            
                            @if($auction->status === 'active')
                                <form action="{{ route('bids.destroy', $userBid->id) }}" method="POST" class="mt-2 inline-block"
                                    onsubmit="return confirm('Are you sure you want to retract your bid of ₱{{ number_format($userBid->amount, 2) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 text-xs text-red-600 underline transition hover:text-red-800">
                                        <i class="ri-delete-bin-6-line text-sm"></i>
                                        Retract Bid
                                    </button>
                                </form>
                            @endif
                        @else
                            <p class="text-lg font-bold text-pink-600">
                                You haven't placed a bid yet.
                            </p>
                        @endif
                    </div>

                    @if($auction->status === 'active')
                        <!-- Quick Bid Form -->
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-3">
                            @foreach([1000, 3000, 5000, 10000, 30000, 50000] as $amount)
                                @php
                                    $yourBid = $currentHighest + $amount;
                                    $label = '₱' . number_format($amount / 1000, 0) . 'K';
                                @endphp

                                <form 
                                    action="{{ route('auctions.bid', $auction->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Place bid of ₱{{ number_format($yourBid, 2) }}?');">
                                    
                                    @csrf
                                    <input type="hidden" name="amount" value="{{ $yourBid }}">

                                    <button type="submit"
                                        @if($isUserHighestBidder || $auction->status !== 'active') disabled @endif
                                        class="flex w-full transform flex-col items-center justify-center rounded-xl bg-gradient-to-br from-purple-100 via-fuchsia-50 to-white px-4 py-3 text-center shadow-sm transition hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 active:scale-100 disabled:cursor-not-allowed disabled:opacity-50">
                                        <i class="ri-auction-line mb-2 text-lg text-purple-500"></i>
                                        <span class="text-xs font-semibold text-purple-700">+{{ $label }}</span>
                                        <span class="text-xs text-fuchsia-500">You’ll bid</span>
                                        <span class="text-sm font-bold text-purple-700">₱{{ number_format($yourBid, 2) }}</span>
                                    </button>
                                </form>
                            @endforeach
                        </div>

                        <!-- Custom Bid Section -->
                        <form action="{{ route('auctions.bid', $auction->id) }}" method="POST" class="mt-8 text-center">
                            @csrf
                            <div class="text-xs font-semibold text-purple-700">
                                Want to place a custom bid?
                            </div>
                            <div class="mt-2 flex flex-col items-center gap-2 text-center sm:flex-row">
                                <input type="number" name="amount" step="0.01" min="0" 
                                    class="h-12 w-full rounded-lg border border-purple-300 px-4 py-3 text-purple-700 placeholder:text-purple-400 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 sm:w-3/4" 
                                    placeholder="Enter your custom bid" 
                                    required 
                                    @if($isUserHighestBidder || $auction->status !== 'active') disabled @endif />

                                <button type="submit" 
                                    class="btn btn-purple mt-2 h-full rounded-lg sm:mt-0 sm:h-12 sm:w-1/4"
                                    @if($isUserHighestBidder || $auction->status !== 'active') disabled @endif>
                                    Bid
                                </button>
                            </div>

                            @if($isUserHighestBidder)
                                <p class="mt-2 text-sm font-medium text-green-600">You already have the highest bid!</p>
                            @endif

                            @error('amount')
                                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </form>
                    @else
                        <p class="mt-4 text-center font-semibold text-gray-600">
                            This auction is no longer active. Bid actions are no longer allowed.
                        </p>
                    
                        @if($auction->status === 'ended' && $isUserHighestBidder)
                            <!-- Buy Now Button -->
                            <div class="mt-6 text-center">
                                <a href="{{ route('purchases.create', ['type' => 'product_auctions', 'id' => $auction->id]) }}"
                                    class="btn btn-purple-to-pink inline-flex rounded-lg shadow-lg">
                                    <i class="ri-shopping-cart-2-line"></i> Buy Now
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

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
            // Countdown Timer Logic
            const countdownTimer = document.getElementById("countdown-timer");
            let timeLeft = {{ $timeRemaining }} * 1000;

            function updateCountdown() {
                if (timeLeft <= 0) {
                    countdownTimer.innerText = "Auction Ended";
                    return;
                }

                timeLeft -= 1000;

                let hours = Math.floor(timeLeft / (1000 * 60 * 60));
                let mins = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                let secs = Math.floor((timeLeft % (1000 * 60)) / 1000);

                countdownTimer.innerText = `${String(hours).padStart(2, '0')}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();

            // Modal Logic
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
