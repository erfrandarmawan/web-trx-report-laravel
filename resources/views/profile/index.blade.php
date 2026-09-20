<x-layouts.app title="Profile">
    <h1 class="text-2xl font-medium mb-6">Profile</h1>

    @if (session('success'))
        <div class="text-sm text-green-600 mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] p-6 max-w-md mb-6">
        <h2 class="text-lg font-medium mb-4">Update Profile</h2>
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                    class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                @error('name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="business_name" class="block text-sm font-medium mb-1">Business Name</label>
                <input type="text" name="business_name" id="business_name" value="{{ old('business_name', auth()->user()->business_name) }}" required
                    class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                @error('business_name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                    class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium hover:bg-black dark:hover:bg-white">
                Save Profile
            </button>
        </form>
    </div>

    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] p-6 max-w-md">
        <h2 class="text-lg font-medium mb-4">Change Password</h2>
        <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
            @csrf

            <div>
                <label for="current_password" class="block text-sm font-medium mb-1">Current Password</label>
                <input type="password" name="current_password" id="current_password" required
                    class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                @error('current_password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-1">New Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
            </div>

            <button type="submit"
                class="px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium hover:bg-black dark:hover:bg-white">
                Change Password
            </button>
        </form>
    </div>
</x-layouts.app>