<x-layouts.guest>
    <h1 class="text-xl font-medium mb-6">Register</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
            @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="business_name" class="block text-sm font-medium mb-1">Business Name</label>
            <input type="text" name="business_name" id="business_name" value="{{ old('business_name') }}" required
                class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
            @error('business_name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
            @error('email')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" id="password" required
                class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
            @error('password')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
        </div>

        <button type="submit"
            class="w-full px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium hover:bg-black dark:hover:bg-white">
            Register
        </button>

        <div class="text-sm text-center">
            <a href="{{ route('login') }}" class="text-[#f53003] dark:text-[#FF4433] underline underline-offset-4">Already have an account? Log in</a>
        </div>
    </form>
</x-layouts.guest>