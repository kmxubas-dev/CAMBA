<!-- Breadcrumb Navigation -->
<nav class="flex rounded-xl bg-gradient-to-br from-purple-600 via-fuchsia-600 to-pink-500 px-4 py-2 shadow-xl" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 text-white md:space-x-3">
        <!-- Home -->
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium">
                <i class="ri-home-4-fill mr-2 text-lg"></i> Home
            </a>
        </li>

        {{-- @include('partials.app_breadcrumbs', ['breadcrumbs' => [['url'=>'/home', 'label'=>'Home']]]) --}}
        @foreach ($breadcrumbs ?? [] as $breadcrumb)
            <li class="inline-flex items-center">
                <a href="{{ $breadcrumb['url'] ?? '#' }}" class="inline-flex items-center text-sm font-medium">
                    <i class="ri-arrow-right-s-line mr-2 text-lg"></i> {{ $breadcrumb['label'] ?? '' }}
                </a>
            </li>
        @endforeach
    </ol>
</nav>
