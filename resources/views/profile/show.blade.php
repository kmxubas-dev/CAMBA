<x-app-layout>
    <div class="mx-auto max-w-3xl px-4 py-3 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-5 rounded-xl bg-gradient-to-r from-purple-600 via-pink-500 to-purple-600 p-6 text-white shadow-lg">
            <h1 class="text-xl font-bold">Edit Profile</h1>
            <p class="text-sm text-purple-100">Update your profile information below.</p>
        </div>

        <!-- Form Card -->
        <div class="rounded-xl border border-purple-100 bg-white p-6 shadow-xl ring-1 ring-purple-50">
            @if(session('status'))
                <div class="mb-6 rounded-md bg-green-100 px-4 py-3 text-sm text-green-800 shadow">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('custom.profile.update') }}" enctype="multipart/form-data" class="space-y-6" id="profileForm">
                @csrf
                @method('PUT')

                <!-- Profile Photo Display -->
                <div class="text-center">
                    <div class="mx-auto mb-4 inline-block h-28 w-28 overflow-hidden rounded-full shadow-lg ring-4 ring-purple-300">
                        <img id="profileImagePreview" src="{{ asset($user->profile_photo_path) }}" alt="Profile Image"
                             class="h-full w-full object-cover" />
                    </div>

                    <!-- Upload Input -->
                    <label for="profile_photo" class="mb-1 block text-sm font-medium text-gray-700">Change Profile Photo</label>
                    <input id="profile_photo" name="profile_photo" type="file" accept="image/*"
                           class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-purple-600 file:px-4 file:py-2 file:font-semibold file:text-white hover:file:bg-purple-700" />
                </div>

                <!-- Name Fields -->
                <div>
                    <h2 class="mb-2 text-lg font-semibold text-gray-800">Name</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
                            <input id="fname" name="fname" type="text" value="{{ old('fname', $user->fname) }}"
                                class="mt-1 w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" />
                        </div>

                        <div>
                            <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input id="lname" name="lname" type="text" value="{{ old('lname', $user->lname) }}"
                                class="mt-1 w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" />
                        </div>
                    </div>
                </div>

                <!-- Email (Disabled) -->
                <div>
                    <h2 class="mb-2 text-lg font-semibold text-gray-800">Email</h2>
                    <input id="email" type="email" value="{{ $user->email }}" disabled
                        class="block w-full cursor-not-allowed rounded-md border border-gray-200 bg-gray-100 px-3 py-2 text-gray-500 shadow-sm sm:text-sm" />
                </div>

                <!-- Additional Info -->
                <div>
                    <h2 class="mb-3 text-lg font-semibold text-gray-800">Additional Information</h2>

                    <div class="space-y-4">
                        <div>
                            <label for="birthdate" class="block text-sm font-medium text-gray-700">Birthdate</label>
                            <input id="birthdate" name="birthdate" type="date"
                                value="{{ old('birthdate', optional($user->info->birthdate)->format('Y-m-d')) }}"
                                class="mt-1 w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" />
                        </div>

                        <div>
                            <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                            <input id="contact" name="contact" type="text"
                                value="{{ old('contact', $user->info->contact) }}"
                                class="mt-1 w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" />
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea id="address" name="address" rows="2"
                                class="mt-1 w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">{{ old('address', $user->info->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pb-3">
                    <button type="submit"
                        class="btn btn-purple-to-pink w-full rounded-lg shadow-xl">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Live Image Preview Script -->
    <script>
        document.getElementById('profile_photo').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profileImagePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>



{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout> --}}
