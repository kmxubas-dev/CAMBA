<x-app-layout>
    <!-- Breadcrumb -->
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'My Artworks', 'url' => route('products.index')],
            ['label' => $product->name]
        ]
    ])

    <!-- Product Details Section -->
    <div class="relative flex flex-col justify-center overflow-hidden py-6">
        <div class="container mx-auto w-full max-w-screen-xl">

            <!-- Header with Title and New Artwork Button -->
            <div class="mb-4 flex items-center justify-between text-base">
                <h3 class="text-2xl">Show Artwork</h3>
                <a href="{{ route('products.create') }}"
                   class="flex items-center rounded-xl bg-purple-600 px-3 py-2 text-white shadow-lg outline-none hover:bg-purple-800">
                    <i class="ri-add-circle-line text-xl"></i>
                    <span class="ml-1">New Artwork</span>
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 flex items-center rounded-lg border-2 border-purple-400 bg-purple-200 p-3 py-2">
                    <i class="ri-check-line text-2xl text-purple-600"></i>
                    <span class="ml-2 text-sm font-semibold text-fuchsia-600">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Main Product Card -->
            <div class="relative flex flex-col rounded-xl bg-gradient-to-tl from-purple-400 to-pink-400 p-6 shadow-lg sm:gap-6 lg:flex-row lg:gap-6">

                <!-- Left: Product Image -->
                <div class="mb-4 lg:mb-0 lg:w-1/2">
                    <div class="relative h-72 w-full overflow-hidden rounded-xl shadow-lg transition-shadow duration-300 hover:shadow-xl sm:h-[400px]">
                        <img
                            src="{{ asset($product->images) }}"
                            alt="{{ $product->name }}"
                            class="h-full w-full cursor-pointer object-cover transition-transform hover:scale-105"
                            onclick="openModal('{{ asset($product->images) }}')"
                            loading="lazy"
                        />
                    </div>

                    <!-- Additional Images -->
                    @if($product->additional_images && count($product->additional_images) > 0)
                        <div class="mt-3 flex gap-2 overflow-x-auto pb-1">
                            @foreach($product->additional_images as $image)
                                <img
                                    src="{{ asset($image) }}"
                                    alt="Additional Image"
                                    class="h-16 w-16 cursor-pointer rounded-xl object-cover transition-transform hover:scale-110 hover:border-2 hover:border-purple-500"
                                    onclick="openModal('{{ asset($image) }}')"
                                    loading="lazy"
                                />
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right: Product Info -->
                <div class="w-full rounded-xl bg-white bg-opacity-50 p-4 shadow-lg backdrop-blur-md sm:p-6 lg:w-1/2">

                    <!-- Product Title and Attributes -->
                    <div class="mb-4">
                        <h2 class="text-3xl font-extrabold text-purple-800 sm:text-4xl">{{ $product->name }}</h2>
                        <p class="mt-2 text-sm font-medium text-purple-700 sm:text-base">
                            <span class="inline-flex items-center gap-1">
                                <i class="ri-palette-line text-lg text-yellow-500"></i>
                                {{ $product->attributes['type'] }}
                            </span>
                            <span class="text-gray-500">•</span>
                            <span class="inline-flex items-center gap-1">
                                <i class="ri-calendar-line text-lg text-yellow-500"></i>
                                {{ $product->attributes['year'] }}
                            </span>
                        </p>
                    </div>

                    <!-- Info Cards: Price, Quantity, Dimensions -->
                    <div class="mb-5 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3">
                        <div class="flex flex-col items-center rounded-lg bg-white/90 p-4 shadow-md hover:shadow-lg">
                            <i class="ri-price-tag-3-line text-3xl text-purple-600"></i>
                            <h5 class="mt-2 text-sm font-semibold text-purple-700">Price</h5>
                            <p class="text-sm font-medium text-purple-800">₱{{ number_format($product->price, 2) }}</p>
                        </div>

                        <div class="flex flex-col items-center rounded-lg bg-white/90 p-4 shadow-md hover:shadow-lg">
                            <i class="ri-numbers-line text-3xl text-purple-600"></i>
                            <h5 class="mt-2 text-sm font-semibold text-purple-700">Quantity</h5>
                            <p class="text-sm font-medium text-purple-800">{{ $product->qty }}</p>
                        </div>

                        <div class="flex flex-col items-center rounded-lg bg-white/90 p-4 shadow-md hover:shadow-lg">
                            <i class="ri-expand-diagonal-line text-3xl text-purple-600"></i>
                            <h5 class="mt-2 text-sm font-semibold text-purple-700">Dimensions</h5>
                            <p class="text-sm font-medium text-purple-800">{{ $product->attributes['size'] }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-1">
                        <h4 class="font-semibold text-purple-700">Description</h4>
                        <p class="text-sm leading-relaxed text-gray-800">{{ $product->description }}</p>
                    </div>

                    <!-- Action Buttons: Edit, Back, Delete -->
                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-start">

                        <!-- Edit Button -->
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="w-full rounded-full border-2 border-transparent bg-purple-600 px-4 py-2 text-center font-medium text-white transition duration-200 hover:bg-purple-700 sm:w-auto">
                            <i class="ri-edit-box-line"></i>
                            Edit
                        </a>

                        <!-- Back Button -->
                        <a href="{{ route('products.index') }}"
                           class="w-full rounded-full border-2 border-purple-600 px-4 py-2 text-center font-medium text-purple-600 transition duration-200 hover:bg-purple-600 hover:text-white sm:w-auto">
                            Back
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this artwork?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full rounded-full border-2 border-pink-300 px-4 py-2 text-center font-medium text-pink-600 transition duration-200 hover:bg-pink-100 hover:text-pink-700 sm:w-auto">
                                <i class="ri-delete-bin-line"></i>
                                Delete
                            </button>
                        </form>

                    </div>

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
        <!-- Scripts Section -->
        <script>
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
