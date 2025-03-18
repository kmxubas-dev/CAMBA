<x-app-layout>
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'Browse Auctions']
        ]
    ])

    <!-- Main Section -->
    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">Browse Auctions</h3>
        </div>

        <div id="auction-list" class="grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-3">
            @foreach ($auctions as $auction)
                <div class="flex flex-col overflow-hidden rounded-2xl border border-purple-100 bg-white shadow-lg transition hover:shadow-2xl">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset($auction->product->images) }}" alt="{{ $auction->product->name }}"
                             class="h-full w-full cursor-pointer object-cover transition-transform duration-300 hover:scale-105">
                        <div class="absolute left-2 top-2 rounded-md bg-purple-600 px-3 py-1 text-xs font-semibold text-white shadow-md">
                            ₱{{ number_format($auction->price, 2) }}
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col justify-between space-y-2 p-4 pt-3">
                        <h3 class="truncate text-xl font-bold text-purple-800 transition hover:text-purple-600">
                            <a href="{{ route('products.show', $auction->product->id) }}" class="flex items-center gap-2 hover:underline">
                                <i class="ri-shopping-bag-3-line text-lg text-purple-400"></i>
                                {{ $auction->product->name }}
                            </a>
                        </h3>

                        <div class="mt-2 space-y-1 text-sm text-gray-700">
                            <!-- Status -->
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

                        <div class="mt-2 flex items-center justify-between gap-2">
                            <div class="inline-block rounded-md bg-gradient-to-r from-pink-100 to-pink-200 px-3 py-1 text-sm font-medium text-pink-700 shadow-inner">
                                by:
                                {{ $auction->user->name }}
                            </div>
                            <a href="{{ route('auctions.show', $auction->id) }}"
                               class="inline-flex items-center gap-1 rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-md transition hover:bg-purple-700 hover:shadow-lg">
                                <i class="ri-eye-line text-base text-white"></i>
                                View Auction
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="show-more-container" class="mt-3 flex justify-center">
            <button id="show-more-btn" class="btn btn-white w-full rounded-lg bg-gray-300 px-6 py-2">
                Show More
            </button>
        </div>
    </section>

    @section('scripts')
        <script>
            let page = 2;
            const showMoreButton = document.getElementById('show-more-btn');
            const auctionList = document.getElementById('auction-list');
            const showMoreContainer = document.getElementById('show-more-container');

            showMoreButton.addEventListener('click', () => {
                loadMoreAuctions();
            });

            function loadMoreAuctions() {
                const url = `{{ route('auctions.index.buyer') }}?page=${page}`;

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    data.auctions.forEach(auction => {
                        const auctionCard = `
                            <div class="flex flex-col overflow-hidden rounded-2xl border border-purple-100 bg-white shadow-lg transition hover:shadow-2xl">
                                <div class="relative h-56 overflow-hidden">
                                    <img src="${auction.product.images}" alt="${auction.product.name}"
                                         class="h-full w-full cursor-pointer object-cover transition-transform duration-300 hover:scale-105">
                                    <div class="absolute left-2 top-2 rounded-md bg-purple-600 px-3 py-1 text-xs font-semibold text-white shadow-md">
                                        ₱${auction.price}
                                    </div>
                                </div>

                                <div class="flex flex-1 flex-col justify-between space-y-2 p-4 pt-3">
                                    <h3 class="truncate text-xl font-bold text-purple-800 transition hover:text-purple-600">
                                        <a href="/products/${auction.product.id}" class="flex items-center gap-2 hover:underline">
                                            <i class="ri-shopping-bag-3-line text-lg text-purple-400"></i>
                                            ${auction.product.name}
                                        </a>
                                    </h3>
                                    <div class="mt-2 space-y-1 text-sm text-gray-700">
                                        <div class="flex items-center gap-2">
                                            <i class="ri-information-line text-purple-500"></i>
                                            <span class="font-semibold text-purple-600">Status:</span>
                                            <span class="inline-block rounded-full bg-purple-100 px-2 py-0.5 text-xs font-semibold text-purple-700">
                                                ${auction.status.charAt(0).toUpperCase() + auction.status.slice(1)}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="ri-trophy-line text-purple-500"></i>
                                            <span class="font-semibold text-purple-600">Winning Bid:</span>
                                            ${auction.bids.length > 0 ? '₱' + auction.bids[auction.bids.length - 1].amount : 'No bids yet'}
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="ri-calendar-event-line text-purple-500"></i>
                                            <span class="font-semibold text-purple-600">Start:</span>
                                            <span>${new Date(auction.start).toLocaleString()}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="ri-calendar-check-line text-purple-500"></i>
                                            <span class="font-semibold text-purple-600">End:</span>
                                            <span>${new Date(auction.end).toLocaleString()}</span>
                                        </div>
                                    </div>

                                    <div class="mt-2 flex items-center justify-between gap-2">
                                        <div class="inline-block rounded-md bg-gradient-to-r from-pink-100 to-pink-200 px-3 py-1 text-sm font-medium text-pink-700 shadow-inner">
                                            by:
                                            ${auction.user.fname} ${auction.user.lname}
                                        </div>
                                        <a href="/auctions/${auction.id}"
                                           class="inline-flex items-center gap-1 rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-md transition hover:bg-purple-700 hover:shadow-lg">
                                            <i class="ri-eye-line text-base text-white"></i>
                                            View Auction
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                        auctionList.insertAdjacentHTML('beforeend', auctionCard);
                    });

                    if (!data.next_page_url) {
                        showMoreButton.style.display = 'none';
                    }

                    page++;
                })
                .catch(error => {
                    console.error('Error loading more auctions:', error);
                });
            }
        </script>
    @endsection
</x-app-layout>
