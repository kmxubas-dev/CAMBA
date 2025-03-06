<x-app-layout>
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [['label' => 'My Bids']]
    ])

    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">Auctions Joined</h3>
        </div>

        <!-- Bid Cards Grid -->
        <div class="grid w-full gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($bids as $bid)
                @php
                    $auction = $bid->auction;
                    $product = $auction->product ?? null;

                    $status = $auction->status;
                    $winningBidAmount = $auction->bids()->max('amount');
                    $isWinning = $bid->amount == $winningBidAmount;

                    $startsAt = \Carbon\Carbon::parse($auction->start)->format('M d, Y');
                    $endsAt = \Carbon\Carbon::parse($auction->end)->format('M d, Y');
                @endphp

                <div class="relative flex flex-col rounded-xl bg-white transition-all duration-300 hover:-translate-y-1 hover:shadow-lg shadow-md ring-1 {{ $isWinning ? 'ring-purple-400' : 'ring-gray-200' }}">

                    <!-- Clickable Overlay -->
                    <a href="{{ route('auctions.show', $auction) }}" class="absolute inset-0 z-10"></a>

                    <!-- Image -->
                    <div class="relative h-32 w-full overflow-hidden rounded-t-xl"> <!-- Increased image height -->
                        <img src="{{ asset($product->images ?? 'placeholder.jpg') }}" 
                            alt="{{ $product->name ?? 'Auction' }}" 
                            class="h-full w-full object-cover transition-transform duration-300 hover:scale-105">

                        <!-- Auction Status Badge -->
                        <div class="absolute top-2 left-2 bg-opacity-75 px-3 py-1 rounded-lg text-white text-xs 
                            {{ in_array($auction->status, ['active', 'paused']) ? 'bg-purple-500' : 'bg-pink-500' }}">
                            {{ ucfirst($auction->status) }}
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="space-y-2 p-4 text-sm text-gray-800">
                        <!-- Product Name -->
                        <h3 class="text-xl font-extrabold tracking-wide text-purple-700 transition-all hover:text-yellow-400">
                            {{ $product->name ?? 'Untitled Artwork' }}
                        </h3>

                        <!-- Auction Dates -->
                        <div class="flex justify-between text-xs text-gray-500">
                            <span><i class="ri-calendar-line text-xs"></i> Starts: {{ $startsAt }}</span>
                            <span><i class="ri-calendar-event-line text-xs"></i> Ends: {{ $endsAt }}</span>
                        </div>

                        <!-- Bidding Info -->
                        <div class="flex justify-between text-sm">
                            <span>Your Bid:</span>
                            <span class="font-semibold text-purple-700">₱{{ number_format($bid->amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Highest Bid:</span>
                            <span>₱{{ number_format($winningBidAmount, 2) }}</span>
                        </div>

                        <!-- Status / Result -->
                        @if($auction->status === 'ended')
                            @if($isWinning)
                                <div class="mt-2 flex items-center gap-1 text-xs font-semibold text-green-800">
                                    <i class="ri-trophy-line"></i> You have won this auction.
                                </div>
                            @else
                                <div class="mt-2 flex items-center gap-1 text-xs font-semibold text-pink-700">
                                    <i class="ri-close-circle-line"></i> Your bid was not successful.
                                </div>
                            @endif
                        @elseif($auction->status === 'sold')
                            <div class="mt-2 flex items-center gap-1 text-xs font-semibold text-blue-700">
                                <i class="ri-check-line"></i> This auction has been sold.
                            </div>
                        @elseif($auction->status === 'paused')
                            <div class="mt-2 flex items-center gap-1 text-xs font-semibold text-yellow-700">
                                <i class="ri-pause-line"></i> This auction is paused.
                            </div>
                        @elseif($auction->status === 'active')
                            @if(!$isWinning)
                                <div class="mt-2 flex items-center gap-1 text-xs font-medium text-purple-400">
                                    <i class="ri-lightbulb-line"></i> Increase your bid to stay competitive.
                                </div>
                            @else
                                <div class="mt-2 flex items-center gap-1 text-xs font-medium text-green-500">
                                    <i class="ri-thumb-up-line"></i> You are currently the highest bidder.
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $bids->links() }}
        </div>
    </section>
</x-app-layout>
