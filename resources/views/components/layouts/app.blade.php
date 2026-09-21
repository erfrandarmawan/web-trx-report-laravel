<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? auth()->user()?->business_name }}</title>
    @fonts
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
    <nav class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4 h-16">
                <a href="{{ route('dashboard') }}" class="text-base sm:text-lg font-medium truncate">Hello, <span class="font-bold uppercase">{{ auth()->user()->name }}</span></a>

                <button type="button" id="nav-toggle"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC]"
                    aria-label="Toggle navigation" aria-expanded="false" aria-controls="nav-menu">
                    <svg id="nav-icon-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="nav-icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="hidden md:flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="text-sm hover:underline">Dashboard</a>
                    <a href="{{ route('transactions.index') }}" class="text-sm hover:underline">Transactions</a>
                    <a href="{{ route('profile.edit') }}" class="text-sm hover:underline">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm hover:underline cursor-pointer">Log out</button>
                    </form>
                </div>
            </div>

            <div id="nav-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col gap-3">
                    <a href="{{ route('dashboard') }}" class="text-sm hover:underline">Dashboard</a>
                    <a href="{{ route('transactions.index') }}" class="text-sm hover:underline">Transactions</a>
                    <a href="{{ route('profile.edit') }}" class="text-sm hover:underline">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm hover:underline cursor-pointer">Log out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 [&>*]:mx-auto">
        {{ $slot }}
    </main>

    <script>
        const navToggle = document.getElementById('nav-toggle');
        const navMenu = document.getElementById('nav-menu');
        const navIconOpen = document.getElementById('nav-icon-open');
        const navIconClose = document.getElementById('nav-icon-close');

        navToggle?.addEventListener('click', () => {
            const isOpen = navMenu.classList.toggle('hidden') === false;
            navToggle.setAttribute('aria-expanded', isOpen);
            navIconOpen.classList.toggle('hidden', isOpen);
            navIconClose.classList.toggle('hidden', !isOpen);
        });
    </script>
</body>
</html>