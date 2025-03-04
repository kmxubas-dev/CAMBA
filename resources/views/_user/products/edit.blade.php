<x-app-layout>
    <!-- Breadcrumb -->
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'My Artworks', 'url' => route('products.index')],
            ['label' => 'Edit: ' . $product->name],
        ]
    ])

    <!-- Main Section -->
    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">Edit Artwork</h3>

            <a href="{{ route('products.index') }}"
                class="btn btn-purple w-auto rounded-xl px-3 py-1.5 shadow-lg">
                <i class="ri-arrow-left-line text-xl"></i>
                <span>Artworks</span>
            </a>
        </div>

        <!-- Edit Artwork Form -->
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                class="relative flex flex-col gap-6 rounded-xl bg-gradient-to-tl from-purple-400 to-pink-400 p-6 shadow-lg lg:flex-row">
            @csrf
            @method('PUT')

            <!-- Left Section: Image Upload -->
            <div class="space-y-4 lg:w-1/2">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <!-- Display Current Image -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-white">Current Image</label>
                        <div class="relative h-72 w-full overflow-hidden rounded-xl border-2 border-transparent shadow-lg sm:h-[300px]">
                            <img src="{{ asset($product->images) }}" alt="Current Image"
                                    class="h-full w-full cursor-pointer rounded-xl object-cover shadow transition hover:scale-105"
                                    onclick="openModal('current', this.src)" />
                        </div>
                        <button type="button"
                                class="btn btn-purple w-full rounded-full shadow-lg"
                                onclick="openModal('current', '{{ asset($product->images) }}')">
                            <i class="ri-eye-line mr-1"></i> View Current Image
                        </button>
                    </div>

                    <!-- Upload New Image -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-white">
                            <i class="ri-image-add-line mr-1"></i> Upload Your Image
                        </label>
                        <div id="dropZone"
                                class="relative flex h-72 w-full items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-pink-600 bg-white/30 shadow-lg sm:h-[300px]">
                            <img id="previewImage" src="" alt="New Image"
                                    class="hidden h-full w-full rounded-xl object-cover shadow"
                                    onclick="openModal('new', this.src)" />
                            <span id="noPreviewText"
                                    class="flex flex-col items-center text-center text-sm text-purple-900">
                                <i class="ri-upload-cloud-2-line mb-1 text-2xl"></i>
                                No image selected yet<br>
                                <span class="text-xs text-purple-800">Click or drag an image here</span>
                            </span>
                            <input type="file" id="imageInput" name="images" accept="image/*"
                                    class="absolute inset-0 h-full w-full cursor-pointer opacity-0" />
                        </div>
                        <button type="button" id="viewNewImageButton"
                                class="btn btn-purple hidden w-full rounded-full shadow-lg"
                                onclick="openNewImageModal()">
                            <i class="ri-eye-line mr-1"></i> Preview Selected Image
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right Section: Artwork Details -->
            <div class="w-full space-y-5 rounded-xl bg-white/50 p-6 shadow-lg backdrop-blur-md lg:w-1/2">

                <!-- Artwork Name -->
                <div>
                    <label class="text-sm font-semibold text-purple-700">Artwork Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                            class="mt-1 w-full rounded-lg border border-purple-200 p-2 text-sm focus:ring-2 focus:ring-purple-400"
                            required>
                </div>

                <!-- Type and Year -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-purple-700">Type</label>
                        <input type="text" name="attributes[type]"
                                value="{{ old('attributes.type', $product->attributes['type']) }}"
                                class="mt-1 w-full rounded-lg border border-purple-200 p-2 text-sm focus:ring-2 focus:ring-purple-400"
                                required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-purple-700">Year</label>
                        <input type="number" name="attributes[year]"
                                value="{{ old('attributes.year', $product->attributes['year']) }}"
                                class="mt-1 w-full rounded-lg border border-purple-200 p-2 text-sm focus:ring-2 focus:ring-purple-400"
                                required>
                    </div>
                </div>

                <!-- Dimensions -->
                <div>
                    <label class="text-sm font-semibold text-purple-700">Dimensions</label>
                    <input type="text" name="attributes[size]"
                            value="{{ old('attributes.size', $product->attributes['size']) }}"
                            class="mt-1 w-full rounded-lg border border-purple-200 p-2 text-sm focus:ring-2 focus:ring-purple-400"
                            required>
                </div>

                <!-- Price and Quantity -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-purple-700">Price (₱)</label>
                        <input type="number" step="0.01" name="price"
                                value="{{ old('price', $product->price) }}"
                                class="mt-1 w-full rounded-lg border border-purple-200 p-2 text-sm focus:ring-2 focus:ring-purple-400"
                                required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-purple-700">Quantity</label>
                        <input type="number" name="qty" value="{{ old('qty', $product->qty) }}"
                                class="mt-1 w-full rounded-lg border border-purple-200 p-2 text-sm focus:ring-2 focus:ring-purple-400"
                                required>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="text-sm font-semibold text-purple-700">Description</label>
                    <textarea name="description" rows="4"
                                class="mt-1 w-full rounded-lg border border-purple-200 p-2 text-sm focus:ring-2 focus:ring-purple-400"
                                required>{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col gap-2 sm:flex-row">
                    <button type="submit"
                            class="btn btn-purple-to-pink rounded-full shadow-xl">
                        <i class="ri-save-line"></i> Save
                    </button>
                    <a href="{{ route('products.show', $product->id) }}"
                        class="btn btn-outline-purple rounded-full">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </section>

    <!-- Modal: Current Image -->
    <div id="currentImageModal"
         class="fixed inset-0 z-50 hidden items-center justify-center overflow-auto bg-black bg-opacity-60 opacity-0 transition-opacity duration-300">
        <div class="relative mx-auto max-h-[90vh] w-full max-w-4xl scale-95 transform rounded-lg bg-gradient-to-tl from-purple-50 via-pink-50 to-yellow-50 p-6 shadow-lg transition-all">
            <button onclick="closeModal('current')"
                    class="absolute right-4 top-4 flex h-12 w-12 items-center justify-center rounded-full bg-purple-600 text-white shadow-lg hover:bg-purple-700">
                <i class="ri-close-line text-2xl"></i>
            </button>
            <img id="currentModalImage" src="" alt="Full Image"
                 class="h-auto max-h-[80vh] w-full rounded-lg border-4 border-yellow-300 object-contain shadow-md" />
        </div>
    </div>

    <!-- Modal: New Selected Image -->
    <div id="newImageModal"
         class="fixed inset-0 z-50 hidden items-center justify-center overflow-auto bg-black bg-opacity-60 opacity-0 transition-opacity duration-300">
        <div class="relative mx-auto max-h-[90vh] w-full max-w-4xl scale-95 transform rounded-lg bg-gradient-to-tl from-purple-50 via-pink-50 to-yellow-50 p-6 shadow-lg transition-all">
            <button onclick="closeModal('new')"
                    class="absolute right-4 top-4 flex h-12 w-12 items-center justify-center rounded-full bg-purple-600 text-white shadow-lg hover:bg-purple-700">
                <i class="ri-close-line text-2xl"></i>
            </button>
            <img id="newModalImage" src="" alt="Full Image"
                 class="h-auto max-h-[80vh] w-full rounded-lg border-4 border-yellow-300 object-contain shadow-md" />
        </div>
    </div>

    @section('scripts')
        <!-- Scripts Section -->
        <script>
            function openModal(type, imageSrc) {
                const modalId = type === 'current' ? 'currentImageModal' : 'newImageModal';
                const modalImageId = type === 'current' ? 'currentModalImage' : 'newModalImage';
                const modal = document.getElementById(modalId);
                modal.style.display = 'flex';
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100', 'scale-100');
                document.getElementById(modalImageId).src = imageSrc;
            }

            function closeModal(type) {
                const modalId = type === 'current' ? 'currentImageModal' : 'newImageModal';
                const modal = document.getElementById(modalId);
                modal.classList.remove('opacity-100', 'scale-100');
                modal.classList.add('opacity-0');
                setTimeout(() => modal.style.display = 'none', 300);
            }

            const imageInput = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');
            const noPreviewText = document.getElementById('noPreviewText');
            const viewNewImageButton = document.getElementById('viewNewImageButton');

            function resetPreview() {
                previewImage.src = '';
                previewImage.style.display = 'none';
                noPreviewText.style.display = 'flex';
                viewNewImageButton.style.display = 'none';
            }

            imageInput.addEventListener('change', () => {
                const file = imageInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        noPreviewText.style.display = 'none';
                        viewNewImageButton.style.display = 'inline-block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    resetPreview();
                }
            });

            function openNewImageModal() {
                openModal('new', previewImage.src);
            }
        </script>
    @endsection
</x-app-layout>
