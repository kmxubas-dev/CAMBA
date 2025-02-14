<x-app-layout>
    <!-- Breadcrumb -->
    <nav class="flex rounded-xl bg-purple-200 p-3 px-5 py-3 text-purple-900" aria-label="Breadcrumb">
        <ol class = "inline-flex items-center space-x-1 md:space-x-3">
            <li class = "inline-flex items-center">
                <a href="#" class="inline-flex items-center text-sm font-medium">
                    <i class="ri-home-4-fill mr-2 text-lg"></i>
                    Home
                </a>
            </li>
        </ol>
    </nav>

    <!-- Products Grid -->
    <div class="relative flex flex-col justify-center overflow-hidden py-6">
        <div class="mx-auto w-full max-w-screen-xl px-1">
            <div class="grid w-full gap-6 sm:grid-cols-2 xl:grid-cols-4">
                @for ($i = 0; $i < 8; $i++)
                    <div class="relative flex max-w-sm flex-col overflow-hidden rounded-xl bg-purple-900 shadow-md transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                        <a href="" class="absolute left-0 top-0 z-20 h-full w-full">&nbsp;</a>
                        <div class="h-auto overflow-hidden">
                            <div class="relative h-56 overflow-hidden">
                                <img src="https://picsum.photos/400/400" alt="">
                            </div>
                        </div>
                        <div class="p-3 px-4 text-purple-100">
                            <h3 class="font-bold text-yellow-300">Product Name</h3>
                            <div class="mb-3 flex items-center justify-between">
                                <p class="line-clamp-5 text-xs text-yellow-200">
                                    by: User Name
                                </p>
                            </div>

                            <div class="mb-3 flex items-center justify-between">
                                <p class="line-clamp-5 text-xs text-purple-300">
                                    Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet
                                    Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet Lorem, ipsum dolor sit amet
                                </p>
                            </div>
                            <div class="flex items-center justify-between align-middle">
                                <p class="text-sm font-semibold text-yellow-200">
                                    ₱12,345.67
                                </p>
                                <div class="relative z-40 flex items-center gap-2">
                                    <a href="" class="z-30 hover:text-yellow-300">
                                        <i class="ri-heart-line text-2xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</x-app-layout>



{{-- <x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>
</x-app-layout> --}}
