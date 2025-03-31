<x-app-layout>
    <!-- Breadcrumb -->
    @include('partials.app_breadcrumbs')

    <!-- Stat Cards -->
    <div class="mt-10">
        <div class="grid gap-x-6 gap-y-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Artworks Posted -->
            <div class="relative flex flex-col rounded-xl bg-white text-gray-700 shadow-md">
                <div class="absolute mx-4 -mt-4 grid h-16 w-16 place-items-center rounded-xl bg-gradient-to-tr from-blue-600 to-blue-400 text-white shadow-lg shadow-blue-500/40">
                    <i class="ri-gallery-fill text-2xl"></i>
                </div>
                <div class="p-4 text-right">
                    <p class="text-sm text-gray-600">Artworks Posted</p>
                    <h4 class="text-2xl font-semibold text-gray-900">{{ $stats['products_count'] }}</h4>
                </div>
                <div class="border-t p-2 text-center">
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-purple-500 hover:text-purple-800">View all</a>
                </div>
            </div>

            <!-- Auctions Started -->
            <div class="relative flex flex-col rounded-xl bg-white text-gray-700 shadow-md">
                <div class="absolute mx-4 -mt-4 grid h-16 w-16 place-items-center rounded-xl bg-gradient-to-tr from-pink-600 to-pink-400 text-white shadow-lg shadow-pink-500/40">
                    <i class="ri-auction-fill text-2xl"></i>
                </div>
                <div class="p-4 text-right">
                    <p class="text-sm text-gray-600">Auctions Started</p>
                    <h4 class="text-2xl font-semibold text-gray-900">{{ $stats['auctions_count'] }}</h4>
                </div>
                <div class="border-t p-2 text-center">
                    <a href="{{ route('auctions.index') }}" class="text-sm font-medium text-purple-500 hover:text-purple-800">View all</a>
                </div>
            </div>

            <!-- Bids Made -->
            <div class="relative flex flex-col rounded-xl bg-white text-gray-700 shadow-md">
                <div class="absolute mx-4 -mt-4 grid h-16 w-16 place-items-center rounded-xl bg-gradient-to-tr from-green-600 to-green-400 text-white shadow-lg shadow-green-500/40">
                    <i class="ri-hand-coin-fill text-2xl"></i>
                </div>
                <div class="p-4 text-right">
                    <p class="text-sm text-gray-600">Bids Made</p>
                    <h4 class="text-2xl font-semibold text-gray-900">{{ $stats['bids_count'] }}</h4>
                </div>
                <div class="border-t p-2 text-center">
                    <a href="{{ route('bids.index') }}" class="text-sm font-medium text-purple-500 hover:text-purple-800">View all</a>
                </div>
            </div>

            <!-- Purchases -->
            <div class="relative flex flex-col rounded-xl bg-white text-gray-700 shadow-md">
                <div class="absolute mx-4 -mt-4 grid h-16 w-16 place-items-center rounded-xl bg-gradient-to-tr from-orange-600 to-orange-400 text-white shadow-lg shadow-orange-500/40">
                    <i class="ri-shopping-cart-fill text-2xl"></i>
                </div>
                <div class="p-4 text-right">
                    <p class="text-sm text-gray-600">Purchases</p>
                    <h4 class="text-2xl font-semibold text-gray-900">{{ $stats['purchases_count'] }}</h4>
                </div>
                <div class="border-t p-2 text-center">
                    <a href="{{ route('purchases.index') }}" class="text-sm font-medium text-purple-500 hover:text-purple-800">View all</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Analytics -->
    <div class="relative flex flex-col justify-center overflow-hidden py-6">
        <div class="mx-auto w-full">
            <h3 class="mb-3 text-2xl font-semibold">Sales Overview</h3>

            <div class="grid gap-8 lg:grid-cols-4">
                <!-- Monthly Sales -->
                <div class="rounded-lg bg-white p-4 shadow-md lg:col-span-3">
                    <h4 class="mb-2 text-lg font-bold">Monthly Sales (₱)</h4>
                    <div class="relative h-72 w-full">
                        <canvas id="monthlySalesChart" class="absolute left-0 top-0 h-full w-full"></canvas>
                    </div>
                </div>

                <!-- Total Sales This Year (₱) -->
                <div class="flex h-full flex-col justify-between">
                    <div class="flex flex-1 flex-col items-center justify-center rounded-lg bg-gradient-to-tr from-purple-600 to-purple-400 p-5 text-white shadow-lg shadow-purple-500/40">
                        <i class="ri-money-dollar-circle-line mb-2 text-4xl"></i> 
                        <h4 class="text-lg font-bold">Total Sales This Year (₱)</h4>
                        <p class="text-2xl font-semibold">₱{{ number_format($sales['total_this_year'], 2) }}</p>
                    </div>

                    <div class="mt-4 flex flex-1 flex-col items-center justify-center rounded-lg bg-gradient-to-tr from-pink-600 to-pink-400 p-5 text-white shadow-lg shadow-pink-500/40">
                        <i class="ri-numbers-fill mb-2 text-4xl"></i> 
                        <h4 class="text-lg font-bold">Total Sales This Year (Count)</h4>
                        <p class="text-2xl font-semibold">{{ $sales['count_this_year'] }} sales</p>
                    </div>
                </div>

                <!-- Total Sales (₱ Overall) -->
                <div class="flex h-full flex-col justify-between">
                    <div class="flex flex-1 flex-col items-center justify-center rounded-lg bg-gradient-to-tr from-fuchsia-600 to-fuchsia-400 p-5 text-white shadow-lg shadow-fuchsia-500/40">
                        <i class="ri-bar-chart-fill mb-2 text-4xl"></i> 
                        <h4 class="text-lg font-bold">Total Sales (₱ Overall)</h4>
                        <p class="text-2xl font-semibold">₱{{ number_format($sales['total'], 2) }}</p>
                    </div>

                    <div class="mt-4 flex flex-1 flex-col items-center justify-center rounded-lg bg-gradient-to-tr from-blue-600 to-blue-400 p-5 text-white shadow-lg shadow-blue-500/40">
                        <i class="ri-bar-chart-line mb-2 text-4xl"></i> 
                        <h4 class="text-lg font-bold">Total Sales (Count Overall)</h4>
                        <p class="text-2xl font-semibold">{{ $sales['count_total'] }} sales</p>
                    </div>
                </div>

                <!-- Pie Chart: Direct vs Auction Sales -->
                <div class="rounded-lg bg-white p-4 shadow-md">
                    <h4 class="mb-2 text-lg font-bold">Direct vs Auction Sales</h4>
                    <div class="relative h-72 w-full">
                        <canvas id="salesTypePieChart" class="absolute left-0 top-0 h-full w-full"></canvas>
                    </div>
                </div>

                <!-- Horizontal Bar Chart: Sold vs Unsold Artworks -->
                <div class="rounded-lg bg-white p-4 shadow-md lg:col-span-2">
                    <h4 class="mb-3 text-lg font-bold">Artworks Sold vs Unsold</h4>
                    <div class="relative h-72 w-full">
                        <canvas id="artworksStatusBarChart" class="absolute left-0 top-0 h-full w-full"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const monthlyData = @json($sales['monthly']);

        new Chart(document.getElementById('monthlySalesChart'), {
            type: 'line',
            data: {
                labels: allMonths,
                datasets: [{
                    label: 'Sales (₱)',
                    data: monthlyData,
                    borderColor: 'rgb(147, 51, 234)',
                    backgroundColor: 'rgba(147, 51, 234, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        new Chart(document.getElementById('salesTypePieChart'), {
            type: 'pie',
            data: {
                labels: ['Direct Purchases', 'Auction Purchases'],
                datasets: [{
                    data: [{{ $sales['direct'] }}, {{ $sales['auction'] }}],
                    backgroundColor: ['#9333EA', '#EC4899']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                return `${label}: ₱${value.toLocaleString()}`;
                            }
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('artworksStatusBarChart'), {
            type: 'bar',
            data: {
                labels: ['Sold Artworks', 'Unsold Artworks'],
                datasets: [{
                    label: 'Artworks',
                    data: [{{ $artworks['sold'] }}, {{ $artworks['unsold'] }}],
                    backgroundColor: ['#9333EA', '#EC4899'],
                    borderRadius: 5,
                    barThickness: 40
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
