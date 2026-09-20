<x-layouts.guest>
    <h1 class="text-xl font-medium mb-6">Forgot Password</h1>

    @if (session('status'))
        <div class="text-sm text-green-600 mb-4">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
            @error('email')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium hover:bg-black dark:hover:bg-white">
            Send Password Reset Link
        </button>

        <div class="text-sm text-center">
            <a href="{{ route('login') }}" class="text-[#f53003] dark:text-[#FF4433] underline underline-offset-4">Back to login</a>
        </div>
    </form>
</x-layouts.guest>