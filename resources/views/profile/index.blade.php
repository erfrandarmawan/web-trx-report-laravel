<x-layouts.app title="Profile">
    <h1 class="text-2xl font-medium mb-6 text-center">Profile</h1>

    @if (session('success'))
        <div class="text-sm text-green-600 mb-4">{{ session('success') }}</div>
    @endif

    @php
        $profileState = $errors->hasAny(['name', 'business_name']) ? 'edit' : 'read';
        $passwordState = $errors->hasAny(['current_password', 'password']) ? 'open' : 'closed';
        $editableClass = 'w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]';
        $readonlyClass = 'bg-gray-100 dark:bg-[#2a2a28] cursor-not-allowed';
    @endphp

    <div id="profile-card" data-state="{{ $profileState }}"
        class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] p-6 max-w-md mb-6">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                    data-original="{{ auth()->user()->name }}"
                    @if ($profileState === 'read') readonly @endif
                    required class="{{ $editableClass }} @if ($profileState === 'read') {{ $readonlyClass }} @endif">
                @error('name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="business_name" class="block text-sm font-medium mb-1">Business Name</label>
                <input type="text" name="business_name" id="business_name"
                    value="{{ old('business_name', auth()->user()->business_name) }}"
                    data-original="{{ auth()->user()->business_name }}"
                    @if ($profileState === 'read') readonly @endif
                    required class="{{ $editableClass }} @if ($profileState === 'read') {{ $readonlyClass }} @endif">
                @error('business_name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                    readonly class="{{ $editableClass }} {{ $readonlyClass }}">
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div data-profile-read class="flex gap-3">
                <button type="button" data-action="edit"
                    class="px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium hover:bg-black dark:hover:bg-white">
                    Edit Profile
                </button>
                <button type="button" data-action="change-password"
                    class="px-5 py-2 border border-[#1b1b18] dark:border-[#eeeeec] rounded-sm text-sm font-medium hover:bg-gray-100 dark:hover:bg-[#2a2a28]">
                    Change Password
                </button>
            </div>

            <div data-profile-edit class="flex gap-3">
                <button type="button" data-action="cancel"
                    class="px-5 py-2 border border-[#1b1b18] dark:border-[#eeeeec] rounded-sm text-sm font-medium hover:bg-gray-100 dark:hover:bg-[#2a2a28]">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium hover:bg-black dark:hover:bg-white">
                    Submit
                </button>
            </div>
        </form>
    </div>

    <div id="password-modal" data-state="{{ $passwordState }}"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="bg-white dark:bg-[#161615] rounded-lg shadow-xl p-6 w-full max-w-md">
            <h2 class="text-lg font-medium mb-4">Change Password</h2>
            <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="current_password" class="block text-sm font-medium mb-1">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required
                        class="{{ $editableClass }}">
                    @error('current_password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium mb-1">New Password</label>
                    <input type="password" name="password" id="password" required class="{{ $editableClass }}">
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="{{ $editableClass }}">
                </div>

                <div class="flex gap-3">
                    <button type="button" data-action="close-password"
                        class="px-5 py-2 border border-[#1b1b18] dark:border-[#eeeeec] rounded-sm text-sm font-medium hover:bg-gray-100 dark:hover:bg-[#2a2a28]">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium hover:bg-black dark:hover:bg-white">
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var card = document.getElementById('profile-card');
            var modal = document.getElementById('password-modal');
            var readonlyClass = @json(explode(' ', $readonlyClass));
            var fields = ['name', 'business_name'];

            function setProfileState(state) {
                card.dataset.state = state;
                var editing = state === 'edit';

                card.querySelectorAll('[data-profile-read]').forEach(function (el) {
                    el.classList.toggle('hidden', editing);
                });
                card.querySelectorAll('[data-profile-edit]').forEach(function (el) {
                    el.classList.toggle('hidden', !editing);
                });

                fields.forEach(function (id) {
                    var input = document.getElementById(id);
                    input.readOnly = !editing;
                    readonlyClass.forEach(function (cls) {
                        input.classList.toggle(cls, !editing);
                    });
                });
            }

            function setPasswordState(state) {
                modal.dataset.state = state;
                var open = state === 'open';
                modal.classList.toggle('hidden', !open);
                modal.classList.toggle('flex', open);
            }

            card.querySelector('[data-action="edit"]').addEventListener('click', function () {
                setProfileState('edit');
            });

            card.querySelector('[data-action="cancel"]').addEventListener('click', function () {
                fields.forEach(function (id) {
                    var input = document.getElementById(id);
                    input.value = input.dataset.original;
                });
                setProfileState('read');
            });

            card.querySelector('[data-action="change-password"]').addEventListener('click', function () {
                setPasswordState('open');
            });

            modal.querySelector('[data-action="close-password"]').addEventListener('click', function () {
                setPasswordState('closed');
            });

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    setPasswordState('closed');
                }
            });

            setProfileState(card.dataset.state);
            setPasswordState(modal.dataset.state);
        })();
    </script>
</x-layouts.app>