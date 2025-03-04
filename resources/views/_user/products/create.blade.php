<x-app-layout>
    <!-- Breadcrumb -->
    @include('partials.app_breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'My Artworks', 'url' => route('products.index')],
            ['label' => 'Add Artwork'],
        ]
    ])

    <!-- Main Section -->
    <section class="container mx-auto flex w-full flex-col justify-center gap-4 py-5">
        <!-- Header -->
        <div class="mx-1 flex items-center justify-between">
            <h3 class="text-2xl">Add Artwork</h3>

            <a href="{{ route('products.index') }}"
                class="btn btn-purple w-auto rounded-xl px-3 py-1.5 shadow-lg">
                <i class="ri-arrow-left-line text-xl"></i>
                <span>Back</span>
            </a>
        </div>

        <div class="flex justify-center">
            <!-- Artwork Create Form -->
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                    class="w-full max-w-3xl space-y-5 rounded-xl bg-gradient-to-tl from-purple-400 to-pink-400 p-5 px-10 pb-10 shadow-lg">
                @csrf

                <!-- Upload Image Section -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-white">
                        <i class="ri-image-add-line mr-1"></i> Upload Your Image
                    </label>

                    <!-- Drag & Drop Zone -->
                    <div id="dropZone"
                            class="relative flex h-48 items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-pink-600 bg-white/30 shadow">
                        <img id="previewImage" src="" alt="New Image"
                                class="hidden h-full w-full object-cover"
                                onclick="openModal('new', this.src)" />

                        <span id="noPreviewText"
                                class="flex flex-col items-center text-center text-sm text-purple-900">
                            <i class="ri-upload-cloud-2-line mb-1 text-2xl"></i>
                            No image selected yet<br>
                            <span class="text-xs text-purple-800">Click or drag an image here</span>
                        </span>

                        <!-- File Input -->
                        <input type="file" id="imageInput" name="images" accept="image/*"
                                class="absolute inset-0 h-full w-full cursor-pointer opacity-0" required />
                    </div>

                    @error('images')
                        <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                    @enderror

                    <!-- Image Preview Button -->
                    <button type="button" id="viewNewImageButton"
                            class="mt-2 hidden w-full items-center justify-center rounded bg-purple-600 px-4 py-2 text-white hover:bg-purple-700"
                            onclick="openNewImageModal()">
                        <i class="ri-eye-line mr-1"></i> Preview Selected Image
                    </button>
                </div>

                <!-- Artwork Form Fields -->
                <div class="space-y-2">
                    <!-- Artwork Name -->
                    <div>
                        <label class="text-sm font-semibold text-purple-700">
                            <i class="ri-brush-line mr-1"></i> Artwork Name
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                                class="mt-1 w-full rounded border border-purple-200 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                        @error('name')
                            <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type and Year -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-sm font-semibold text-purple-700">
                                <i class="ri-palette-line mr-1"></i> Type
                            </label>
                            <input type="text" name="attributes[type]" value="{{ old('attributes.type') }}"
                                    class="mt-1 w-full rounded border border-purple-200 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                            @error('attributes.type')
                                <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-purple-700">
                                <i class="ri-calendar-2-line mr-1"></i> Year
                            </label>
                            <input type="number" name="attributes[year]" value="{{ old('attributes.year') }}"
                                    class="mt-1 w-full rounded border border-purple-200 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                            @error('attributes.year')
                                <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Size -->
                    <div>
                        <label class="text-sm font-semibold text-purple-700">
                            <i class="ri-resize-width-line mr-1"></i> Dimensions
                        </label>
                        <input type="text" name="attributes[size]" value="{{ old('attributes.size') }}"
                                class="mt-1 w-full rounded border border-purple-200 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                        @error('attributes.size')
                            <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price and Quantity -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-sm font-semibold text-purple-700">
                                <i class="ri-money-pound-circle-line mr-1"></i> Price (₱)
                            </label>
                            <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                                    class="mt-1 w-full rounded border border-purple-200 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                            @error('price')
                                <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-purple-700">
                                <i class="ri-stack-line mr-1"></i> Quantity
                            </label>
                            <input type="number" name="qty" value="{{ old('qty') }}"
                                    class="mt-1 w-full rounded border border-purple-200 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600" required>
                            @error('qty')
                                <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="text-sm font-semibold text-purple-700">
                            <i class="ri-file-text-line mr-1"></i> Description
                        </label>
                        <textarea name="description" rows="3"
                                    class="mt-1 w-full rounded border border-purple-200 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600"
                                    required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action Buttons: Submit, Cancel -->
                    <div class="flex flex-col gap-3 pt-3 sm:flex-row">
                        <button type="submit"
                                class="btn btn-purple-to-pink rounded-full shadow-xl">
                            <i class="ri-save-line"></i> Save
                        </button>
                        <a href="{{ route('products.index') }}"
                            class="btn btn-outline-purple rounded-full">
                            <i class="ri-close-line"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Modal: Full Image Viewer -->
    <div id="newImageModal"
         class="fixed inset-0 z-50 hidden items-center justify-center overflow-auto bg-black bg-opacity-60 opacity-0 transition-opacity duration-300">
        <div class="relative mx-auto max-h-[90vh] w-full max-w-4xl scale-95 transform rounded-lg bg-gradient-to-tl from-purple-50 via-pink-50 to-yellow-50 p-6 shadow-lg transition-all">
            <!-- Close Modal Button -->
            <button onclick="closeModal('new')"
                    class="absolute right-4 top-4 flex h-12 w-12 items-center justify-center rounded-full bg-purple-600 text-white shadow-lg hover:bg-purple-700">
                <i class="ri-close-line text-2xl"></i>
            </button>

            <!-- Modal Image -->
            <img id="newModalImage" src="" alt="Full Image"
                 class="h-auto max-h-[80vh] w-full rounded-lg border-4 border-yellow-300 object-contain shadow-md" />
        </div>
    </div>

    @section('scripts')
        <!-- Scripts Section -->
        <script>
            const imageInput = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');
            const noPreviewText = document.getElementById('noPreviewText');
            const viewNewImageButton = document.getElementById('viewNewImageButton');

            imageInput.addEventListener('change', () => {
                const file = imageInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        noPreviewText.style.display = 'none';
                        viewNewImageButton.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.src = '';
                    previewImage.style.display = 'none';
                    noPreviewText.style.display = 'flex';
                    viewNewImageButton.style.display = 'none';
                }
            });

            function openNewImageModal() {
                const src = previewImage.src;
                if (src) {
                    openModal('new', src);
                }
            }

            function openModal(type, imageSrc) {
                const modalId = type === 'new' ? 'newImageModal' : 'currentImageModal';
                const modalImageId = type === 'new' ? 'newModalImage' : 'currentModalImage';
                const modal = document.getElementById(modalId);
                modal.style.display = 'flex';
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                document.getElementById(modalImageId).src = imageSrc;
            }

            function closeModal(type) {
                const modalId = type === 'new' ? 'newImageModal' : 'currentImageModal';
                const modal = document.getElementById(modalId);
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0');
                setTimeout(() => modal.style.display = 'none', 300);
            }
        </script>
    @endsection
</x-app-layout>
