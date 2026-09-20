<x-layouts.guest>
    <h1 class="text-xl font-medium mb-6">Log in</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
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

        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember" class="text-sm">Remember me</label>
        </div>

        <button type="submit"
            class="w-full px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium hover:bg-black dark:hover:bg-white">
            Log in
        </button>

        <div class="text-sm text-center space-y-2">
            <a href="{{ route('password.request') }}" class="text-[#f53003] dark:text-[#FF4433] underline underline-offset-4">Forgot your password?</a>
            <br>
            <a href="{{ route('register') }}" class="text-[#f53003] dark:text-[#FF4433] underline underline-offset-4">Don't have an account? Register</a>
        </div>
    </form>
</x-layouts.guest>