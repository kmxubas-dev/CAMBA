<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8"> <!-- Default -->
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Default -->
        <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Default -->
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{ config('app.name', 'Laravel') }} @yield('title')</title> <!-- Default -->

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net"> <!-- Default -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> <!-- Default -->

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Default -->

        <!-- Styles -->
        @livewireStyles <!-- Default -->

        @yield('styles')

        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.min.css" rel="stylesheet">

        <style>
            /*
            ! tailwindcss v3.3.3 | MIT License | https://tailwindcss.com
            */

            .bg-black\/50{
                background-color: rgb(0 0 0 / 0.5);
            }

            .bg-blue-500\/10{
                background-color: rgb(59 130 246 / 0.1);
            }

            .bg-emerald-500\/10{
                background-color: rgb(16 185 129 / 0.1);
            }

            .bg-rose-500\/10{
                background-color: rgb(244 63 94 / 0.1);
            }

            .bg-select-arrow{
                background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZD0iTTExLjk5OTcgMTMuMTcxNEwxNi45NDk1IDguMjIxNjhMMTguMzYzNyA5LjYzNTg5TDExLjk5OTcgMTUuOTk5OUw1LjYzNTc0IDkuNjM1ODlMNy4wNDk5NiA4LjIyMTY4TDExLjk5OTcgMTMuMTcxNFoiIGZpbGw9InJnYmEoMTU2LDE2MywxNzUsMSkiPjwvcGF0aD48L3N2Zz4=");
            }

            .shadow-black\/5{
                --tw-shadow-color: rgb(0 0 0 / 0.05);
                --tw-shadow: var(--tw-shadow-colored);
            }

            .notification-tab > .active{
                --tw-border-opacity: 1;
                border-bottom-color: rgb(59 130 246 / var(--tw-border-opacity));
                --tw-text-opacity: 1;
                color: rgb(59 130 246 / var(--tw-text-opacity));
            }

            .notification-tab > .active:hover{
                --tw-text-opacity: 1;
                color: rgb(59 130 246 / var(--tw-text-opacity));
            }

            .order-tab > .active{
                --tw-bg-opacity: 1;
                background-color: rgb(59 130 246 / var(--tw-bg-opacity));
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity));
            }

            .order-tab > .active:hover{
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity));
            }

            .group:hover .group-hover\:text-blue-500{
                --tw-text-opacity: 1;
                color: rgb(59 130 246 / var(--tw-text-opacity));
            }

            .group.selected .group-\[\.selected\]\:block{
                display: block;
            }

            .group.selected .group-\[\.selected\]\:rotate-90{
                --tw-rotate: 90deg;
                transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
            }

            .group.active .group-\[\.active\]\:bg-gray-800{
                --tw-bg-opacity: 1;
                background-color: rgb(31 41 55 / var(--tw-bg-opacity));
            }

            .group.selected .group-\[\.selected\]\:bg-gray-950{
                --tw-bg-opacity: 1;
                background-color: rgb(3 7 18 / var(--tw-bg-opacity));
            }

            .group.active .group-\[\.active\]\:text-white{
                --tw-text-opacity: 1;
                color: rgb(255 255 255 / var(--tw-text-opacity));
            }

            .group.selected .group-\[\.selected\]\:text-gray-100{
                --tw-text-opacity: 1;
                color: rgb(243 244 246 / var(--tw-text-opacity));
            }

            @media (min-width: 768px){
                .main.active{
                    margin-left: 0px;
                    width: 100%;
                }
            }
        </style>
    </head>
    <body class="bg-gray-200 font-sans text-purple-950 antialiased">
        <!--sidenav -->
        <div class="sidebar-menu fixed left-0 top-0 z-50 h-full w-64 bg-transparent transition-transform">
            <a href="{{ route('dashboard') }}" class="flex h-16 items-center justify-center bg-white p-2 shadow-md">
                <img src="{{ asset('assets/img/logo_text.png') }}" alt="App Logo" class="h-full"/>
            </a>

            <div class="h-full px-3 py-4 pb-20">
                <ul class="h-full overflow-auto rounded-xl bg-gradient-to-br from-purple-800 via-fuchsia-700 to-pink-600 p-3 shadow-xl">

                    <li class="group mb-1 text-white">
                        <a href="{{ route('profile.show') }}" class="flex items-center rounded-md p-2 hover:bg-purple-950">
                            <div class="relative h-10 w-10 flex-shrink-0">
                                <div class="rounded-full bg-white p-1 focus:outline-none focus:ring">
                                    <img class="h-8 w-8 rounded-full" src="https://laravelui.spruko.com/tailwind/ynex/build/assets/images/faces/9.jpg" alt=""/>
                                    <div class="absolute left-7 top-0 h-3 w-3 animate-ping rounded-full border-2 border-white bg-lime-400"></div>
                                    <div class="absolute left-7 top-0 h-3 w-3 rounded-full border-2 border-white bg-lime-500"></div>
                                </div>
                            </div>
                            <div class="p-2 text-left md:block">
                                <h2 class="text-sm font-bold">{{ Auth::user()->name }}</h2>
                                <p class="text-xs text-purple-300">Profile</p>
                            </div>
                        </a>
                    </li>
                    <li class="group mx-3 my-2 border-b border-purple-600"></li>

                    <li class="group mb-1 text-white">
                        <a href="{{ route('dashboard') }}" class="flex items-center rounded-md px-4 py-2 hover:bg-purple-950">
                            <i class="ri-home-9-fill mr-3 text-lg"></i>
                            <span class="text-sm font-semibold">Home</span>
                        </a>
                    </li>

                    <li class="group mb-1 text-white">
                        <button type="button" class="sidebar-dropdown-toggle flex w-full items-center rounded-md px-4 py-2 font-semibold transition hover:bg-purple-950">
                            <i class="ri-brush-3-fill mr-3 text-lg"></i>
                            <span class="text-sm">My Studio</span>
                            <i class="ri-arrow-down-s-line ml-auto transition-transform group-[.selected]:rotate-90"></i>
                        </button>
                        <ul class="mt-2 hidden space-y-3 pl-7 text-purple-200 group-[.selected]:block">
                            <li>
                                <a href="{{ route('products.index') }}" class="flex items-center text-sm transition hover:text-white">
                                    <i class="ri-image-fill mr-2 text-sm text-purple-400"></i>
                                    My Artworks
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('auctions.index') }}" class="flex items-center text-sm transition hover:text-white">
                                    <i class="ri-auction-fill mr-2 text-sm text-purple-400"></i>
                                    My Auctions
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="group mb-1 text-white">
                        <button type="button" class="sidebar-dropdown-toggle flex w-full items-center rounded-md px-4 py-2 font-semibold transition hover:bg-purple-950">
                            <i class="ri-store-3-fill mr-3 text-lg"></i>
                            <span class="text-sm">Marketplace</span>
                            <i class="ri-arrow-down-s-line ml-auto transition-transform group-[.selected]:rotate-90"></i>
                        </button>
                        <ul class="mt-2 hidden space-y-3 pl-7 text-purple-200 group-[.selected]:block">
                            <li>
                                <a 
                                    href="{{ route('products.index.buyer') }}"
                                    class="flex items-center text-sm transition hover:text-white"
                                >
                                    <i class="ri-gallery-fill mr-2 text-sm text-purple-400"></i>
                                    Browse Artworks
                                </a>
                            </li>
                            <li>
                                <a 
                                    href="{{ route('auctions.index.buyer') }}"
                                    class="flex items-center text-sm transition hover:text-white"
                                >
                                    <i class="ri-auction-fill mr-2 text-sm text-purple-400"></i>
                                    Browse Auctions
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="group mb-1 text-white">
                        <a href="{{ route('bids.index') }}" class="flex items-center rounded-md px-4 py-2 hover:bg-purple-950">
                            <i class="ri-auction-fill mr-3 text-lg"></i>
                            <span class="text-sm font-semibold">Auctions joined</span>
                        </a>
                    </li>

                    <li class="group mb-1 text-white">
                        <a href="{{ route('purchases.index') }}" class="flex items-center rounded-md px-4 py-2 hover:bg-purple-950">
                            <i class="ri-shopping-bag-3-fill mr-3 text-lg"></i>
                            <span class="text-sm font-semibold">All Purchases</span>
                        </a>
                    </li>

                    <li class="group mx-3 my-2 border-b border-purple-600"></li>
                    <li class="group mb-1 text-white">
                        <form method="POST" action="{{ route('logout') }}" x-data="" class="flex">
                            @csrf
                            <button type="submit" class="flex w-full items-center rounded-md px-4 py-2 hover:bg-purple-950" @click.prevent="$root.submit();">
                                <i class="ri-logout-box-r-line mr-3 text-lg"></i>
                                <span class="text-sm font-semibold">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar-overlay fixed left-0 top-0 z-40 h-full w-full bg-black/50 md:hidden"></div>
        <!-- end sidenav -->

        <main class="main min-h-screen w-full transition-all md:ml-64 md:w-[calc(100%-256px)]">
            <!-- navbar -->
            <nav class="sticky left-0 top-0 z-30 flex h-16 items-center bg-white px-6 py-2 shadow-md">
                <!-- menu icon -->
                <button type="button" class="sidebar-toggle text-lg font-semibold text-purple-800">
                    <i class="ri-menu-line"></i>
                </button>

                <ul class="ml-auto flex items-center">
                    <!-- fullscreen icon -->
                    <button id="fullscreen-button" class="mr-4 flex h-8 w-8 items-center justify-center rounded hover:bg-purple-200">
                        <i class="ri-fullscreen-line text-2xl text-purple-900"></i>
                    </button>
                    <script>
                        const fullscreenButton = document.getElementById('fullscreen-button');

                        fullscreenButton.addEventListener('click', toggleFullscreen);

                        function toggleFullscreen() {
                            if (document.fullscreenElement) {
                                // If already in fullscreen, exit fullscreen
                                document.exitFullscreen();
                            } else {
                                // If not in fullscreen, request fullscreen
                                document.documentElement.requestFullscreen();
                            }
                        }
                    </script>

                    <!-- search icon -->
                    <li class="dropdown">
                        <button type="button" class="dropdown-toggle mr-4 flex h-8 w-8 items-center justify-center rounded hover:bg-purple-200">
                            <i class="ri-search-line text-2xl text-purple-900"></i>
                        </button>
                        <div class="dropdown-menu z-30 hidden w-full max-w-xs rounded-md border border-gray-100 bg-white shadow-md shadow-black/5">
                            <form action="{{ route('search') }}" method="GET" class="border-b border-b-gray-100 p-4">
                                <div class="relative w-full">
                                    <input 
                                        type="text" 
                                        name="query" 
                                        value="{{ request('query') }}" 
                                        class="w-full rounded-md border border-gray-100 bg-gray-50 py-2 pl-10 pr-4 text-sm outline-none focus:border-blue-500" 
                                        placeholder="Search..."
                                    >
                                    <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-gray-900"></i>
                                </div>
                            </form>
                        </div>
                    </li>

                    {{-- <!-- notifications icon -->
                    <li class="dropdown">
                        <button type="button" class="dropdown-toggle mr-4 flex h-8 w-8 items-center justify-center rounded hover:bg-purple-200">
                            <i class="ri-notification-3-line text-2xl text-purple-900"></i>
                        </button>
                        <div class="dropdown-menu z-30 hidden w-full max-w-xs rounded-md border border-gray-100 bg-white shadow-md shadow-black/5">
                            <div class="notification-tab flex items-center border-b border-b-gray-100 px-4 pt-4">
                                <button type="button" data-tab="notification" data-tab-page="notifications" class="active mr-4 border-b-2 border-b-transparent pb-1 text-[13px] font-medium text-gray-400 hover:text-gray-600">Notifications</button>
                                <button type="button" data-tab="notification" data-tab-page="messages" class="mr-4 border-b-2 border-b-transparent pb-1 text-[13px] font-medium text-gray-400 hover:text-gray-600">Messages</button>
                            </div>
                            <div class="my-2">
                                <ul class="max-h-64 overflow-y-auto" data-tab-for="notification" data-page="notifications">
                                    <li>
                                        <a href="#" class="group flex items-center px-4 py-2 hover:bg-gray-50">
                                            <img src="https://placehold.co/32x32" alt="" class="block h-8 w-8 rounded object-cover align-middle">
                                            <div class="ml-2">
                                                <div class="truncate text-[13px] font-medium text-gray-600 group-hover:text-blue-500">New order</div>
                                                <div class="text-[11px] text-gray-400">from a user</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="group flex items-center px-4 py-2 hover:bg-gray-50">
                                            <img src="https://placehold.co/32x32" alt="" class="block h-8 w-8 rounded object-cover align-middle">
                                            <div class="ml-2">
                                                <div class="truncate text-[13px] font-medium text-gray-600 group-hover:text-blue-500">New order</div>
                                                <div class="text-[11px] text-gray-400">from a user</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="group flex items-center px-4 py-2 hover:bg-gray-50">
                                            <img src="https://placehold.co/32x32" alt="" class="block h-8 w-8 rounded object-cover align-middle">
                                            <div class="ml-2">
                                                <div class="truncate text-[13px] font-medium text-gray-600 group-hover:text-blue-500">New order</div>
                                                <div class="text-[11px] text-gray-400">from a user</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="group flex items-center px-4 py-2 hover:bg-gray-50">
                                            <img src="https://placehold.co/32x32" alt="" class="block h-8 w-8 rounded object-cover align-middle">
                                            <div class="ml-2">
                                                <div class="truncate text-[13px] font-medium text-gray-600 group-hover:text-blue-500">New order</div>
                                                <div class="text-[11px] text-gray-400">from a user</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="group flex items-center px-4 py-2 hover:bg-gray-50">
                                            <img src="https://placehold.co/32x32" alt="" class="block h-8 w-8 rounded object-cover align-middle">
                                            <div class="ml-2">
                                                <div class="truncate text-[13px] font-medium text-gray-600 group-hover:text-blue-500">New order</div>
                                                <div class="text-[11px] text-gray-400">from a user</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="hidden max-h-64 overflow-y-auto" data-tab-for="notification" data-page="messages">
                                    <li>
                                        <a href="#" class="group flex items-center px-4 py-2 hover:bg-gray-50">
                                            <img src="https://placehold.co/32x32" alt="" class="block h-8 w-8 rounded object-cover align-middle">
                                            <div class="ml-2">
                                                <div class="truncate text-[13px] font-medium text-gray-600 group-hover:text-blue-500">John Doe</div>
                                                <div class="text-[11px] text-gray-400">Hello there!</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="group flex items-center px-4 py-2 hover:bg-gray-50">
                                            <img src="https://placehold.co/32x32" alt="" class="block h-8 w-8 rounded object-cover align-middle">
                                            <div class="ml-2">
                                                <div class="truncate text-[13px] font-medium text-gray-600 group-hover:text-blue-500">John Doe</div>
                                                <div class="text-[11px] text-gray-400">Hello there!</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="group flex items-center px-4 py-2 hover:bg-gray-50">
                                            <img src="https://placehold.co/32x32" alt="" class="block h-8 w-8 rounded object-cover align-middle">
                                            <div class="ml-2">
                                                <div class="truncate text-[13px] font-medium text-gray-600 group-hover:text-blue-500">John Doe</div>
                                                <div class="text-[11px] text-gray-400">Hello there!</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="group flex items-center px-4 py-2 hover:bg-gray-50">
                                            <img src="https://placehold.co/32x32" alt="" class="block h-8 w-8 rounded object-cover align-middle">
                                            <div class="ml-2">
                                                <div class="truncate text-[13px] font-medium text-gray-600 group-hover:text-blue-500">John Doe</div>
                                                <div class="text-[11px] text-gray-400">Hello there!</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="group flex items-center px-4 py-2 hover:bg-gray-50">
                                            <img src="https://placehold.co/32x32" alt="" class="block h-8 w-8 rounded object-cover align-middle">
                                            <div class="ml-2">
                                                <div class="truncate text-[13px] font-medium text-gray-600 group-hover:text-blue-500">John Doe</div>
                                                <div class="text-[11px] text-gray-400">Hello there!</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li> --}}
                </ul>
            </nav>
            <!-- end navbar -->

            <!-- Content -->
            <section class="p-5">
                <x-banner />

                {{ $slot }}
            </section>
            <!-- End Content -->
        </main>

        @stack('modals') <!-- Default -->

        @livewireScripts <!-- Default -->

        @yield('scripts')

        <script src="https://unpkg.com/@popperjs/core@2"></script>

        <script>
            // start: Sidebar
            const sidebarToggle = document.querySelector('.sidebar-toggle')
            const sidebarOverlay = document.querySelector('.sidebar-overlay')
            const sidebarMenu = document.querySelector('.sidebar-menu')
            const main = document.querySelector('.main')
            sidebarToggle.addEventListener('click', function (e) {
                e.preventDefault()
                main.classList.toggle('active')
                sidebarOverlay.classList.toggle('hidden')
                sidebarMenu.classList.toggle('-translate-x-full')
            })
            sidebarOverlay.addEventListener('click', function (e) {
                e.preventDefault()
                main.classList.add('active')
                sidebarOverlay.classList.add('hidden')
                sidebarMenu.classList.add('-translate-x-full')
            })
            document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.preventDefault()
                    const parent = item.closest('.group')
                    if (parent.classList.contains('selected')) {
                        parent.classList.remove('selected')
                    } else {
                        document.querySelectorAll('.sidebar-dropdown-toggle').forEach(function (i) {
                            i.closest('.group').classList.remove('selected')
                        })
                        parent.classList.add('selected')
                    }
                })
            })
            // end: Sidebar



            // start: Popper
            const popperInstance = {}
            document.querySelectorAll('.dropdown').forEach(function (item, index) {
                const popperId = 'popper-' + index
                const toggle = item.querySelector('.dropdown-toggle')
                const menu = item.querySelector('.dropdown-menu')
                menu.dataset.popperId = popperId
                popperInstance[popperId] = Popper.createPopper(toggle, menu, {
                    modifiers: [
                        {
                            name: 'offset',
                            options: {
                                offset: [0, 8],
                            },
                        },
                        {
                            name: 'preventOverflow',
                            options: {
                                padding: 24,
                            },
                        },
                    ],
                    placement: 'bottom-end'
                });
            })
            document.addEventListener('click', function (e) {
                const toggle = e.target.closest('.dropdown-toggle')
                const menu = e.target.closest('.dropdown-menu')
                if (toggle) {
                    const menuEl = toggle.closest('.dropdown').querySelector('.dropdown-menu')
                    const popperId = menuEl.dataset.popperId
                    if (menuEl.classList.contains('hidden')) {
                        hideDropdown()
                        menuEl.classList.remove('hidden')
                        showPopper(popperId)
                    } else {
                        menuEl.classList.add('hidden')
                        hidePopper(popperId)
                    }
                } else if (!menu) {
                    hideDropdown()
                }
            })

            function hideDropdown() {
                document.querySelectorAll('.dropdown-menu').forEach(function (item) {
                    item.classList.add('hidden')
                })
            }
            function showPopper(popperId) {
                popperInstance[popperId].setOptions(function (options) {
                    return {
                        ...options,
                        modifiers: [
                            ...options.modifiers,
                            { name: 'eventListeners', enabled: true },
                        ],
                    }
                });
                popperInstance[popperId].update();
            }
            function hidePopper(popperId) {
                popperInstance[popperId].setOptions(function (options) {
                    return {
                        ...options,
                        modifiers: [
                            ...options.modifiers,
                            { name: 'eventListeners', enabled: false },
                        ],
                    }
                });
            }
            // end: Popper



            // start: Tab
            document.querySelectorAll('[data-tab]').forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.preventDefault()
                    const tab = item.dataset.tab
                    const page = item.dataset.tabPage
                    const target = document.querySelector('[data-tab-for="' + tab + '"][data-page="' + page + '"]')
                    document.querySelectorAll('[data-tab="' + tab + '"]').forEach(function (i) {
                        i.classList.remove('active')
                    })
                    document.querySelectorAll('[data-tab-for="' + tab + '"]').forEach(function (i) {
                        i.classList.add('hidden')
                    })
                    item.classList.add('active')
                    target.classList.remove('hidden')
                })
            })
            // end: Tab



            document.addEventListener('contextmenu', event => event.preventDefault());
        </script>
    </body>
</html>
