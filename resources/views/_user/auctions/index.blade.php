<x-app-layout>
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'My Auctions', 'url' => route('auctions.index')]
        ]
    ])

    <!-- Main Section -->
    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">My Auctions</h3>

            <a href="{{ route('auctions.create') }}"
               class="btn btn-purple w-auto rounded-xl px-3 py-1.5 shadow-lg">
                <i class="ri-add-circle-line text-xl"></i>
                <span>New Auction</span>
            </a>
        </div>

        <!-- Auction Grid -->
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 xl:grid-cols-3">
            @forelse ($auctions as $auction)
                <div class="flex flex-col overflow-hidden rounded-2xl border border-purple-100 bg-white shadow-lg transition hover:shadow-2xl">
                    <!-- Image -->
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset($auction->product->images) }}"
                             alt="{{ $auction->product->name }}"
                             class="h-full w-full cursor-pointer object-cover transition-transform duration-300 hover:scale-105"
                             loading="lazy">
                    
                        <!-- Starting Price Badge -->
                        <div class="absolute left-2 top-2 rounded-md bg-purple-600 px-3 py-1 text-xs font-semibold text-white shadow-md">
                            ₱{{ number_format($auction->price, 2) }}
                        </div>
                    </div>                    
                    
                    <!-- Content -->
                    <div class="flex flex-1 flex-col justify-between space-y-2 p-4 pt-3">
                        <div>
                            <!-- Product Name -->
                            <h3 class="truncate text-xl font-bold text-purple-800 transition hover:text-purple-600">
                                <a href="{{ route('products.show', $auction->product->id) }}"
                                   class="flex items-center gap-2 hover:underline">
                                    <i class="ri-shopping-bag-3-line text-lg text-purple-400"></i>
                                    {{ $auction->product->name }}
                                </a>
                            </h3>

                            <!-- Info Block -->
                            <div class="mt-2 space-y-1 text-sm text-gray-700">
                                <div class="flex items-center gap-2">
                                    <i class="ri-information-line text-purple-500"></i>
                                    <span class="font-semibold text-purple-600">Status:</span>
                                    <span class="inline-block rounded-full bg-purple-100 px-2 py-0.5 text-xs font-semibold text-purple-700">
                                        {{ ucfirst($auction->status) }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <i class="ri-trophy-line text-purple-500"></i>
                                    <span class="font-semibold text-purple-600">Winning Bid:</span>
                                    @if ($auction->bids->count() > 0)
                                        <span>₱{{ number_format($auction->bids->max('amount'), 2) }}</span>
                                    @else
                                        <span class="text-gray-400">No bids yet</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <i class="ri-calendar-event-line text-purple-500"></i>
                                    <span class="font-semibold text-purple-600">Start:</span>
                                    <span>{{ $auction->start->format('M d, Y h:i A') }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <i class="ri-calendar-check-line text-purple-500"></i>
                                    <span class="font-semibold text-purple-600">End:</span>
                                    <span>{{ $auction->end->format('M d, Y h:i A') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Timer + Link -->
                        <div class="mt-2 flex items-center justify-between gap-2">
                            <div id="countdown-timer-{{ $auction->id }}"
                                 class="inline-block rounded-md bg-gradient-to-r from-pink-100 to-pink-200 px-3 py-1 text-sm font-bold text-pink-700 shadow-inner">
                                <i class="ri-timer-line mr-1 text-pink-500"></i> --:--
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('auctions.show', $auction->id) }}"
                                   class="inline-flex items-center gap-1 rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-md transition hover:bg-purple-700 hover:shadow-lg">
                                    <i class="ri-eye-line text-base text-white"></i>
                                    View Auction
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500">
                    <p class="font-semibold text-pink-500">You don’t have any auctions yet.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $auctions->links('pagination::tailwind') }}
        </div>
    </section>

    @section('scripts')
        <script>
            // Countdown Timers
            @foreach($auctions as $auction)
                const countdownTimer{{ $auction->id }} = document.getElementById("countdown-timer-{{ $auction->id }}");
                let timeLeft{{ $auction->id }} = {{ $auction->timeRemaining }} * 1000;

                function updateCountdown{{ $auction->id }}() {
                    if (timeLeft{{ $auction->id }} <= 0) {
                        countdownTimer{{ $auction->id }}.innerText = "Auction Ended";
                        return;
                    }

                    timeLeft{{ $auction->id }} -= 1000;

                    const hours = Math.floor(timeLeft{{ $auction->id }} / (1000 * 60 * 60));
                    const mins = Math.floor((timeLeft{{ $auction->id }} % (1000 * 60 * 60)) / (1000 * 60));
                    const secs = Math.floor((timeLeft{{ $auction->id }} % (1000 * 60)) / 1000);

                    countdownTimer{{ $auction->id }}.innerText =
                        `${String(hours).padStart(2, '0')}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                }

                setInterval(updateCountdown{{ $auction->id }}, 1000);
                updateCountdown{{ $auction->id }}();
            @endforeach
        </script>
    @endsection
</x-app-layout>
