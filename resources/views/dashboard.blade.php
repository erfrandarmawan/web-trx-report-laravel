<x-layouts.app :title="'Dashboard - ' . auth()->user()->business_name">
    @php
        $maxValue = max($chartValues ?: [0]) ?: 1;
        $ranges = [
            'today' => 'Today',
            '7days' => 'Last 7 Days',
            '30days' => 'Last 30 Days',
            'month' => 'This Month',
        ];
    @endphp

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl font-medium">Dashboard - {{ auth()->user()->business_name }}</h1>

        <div class="flex flex-wrap gap-2">
            @foreach ($ranges as $value => $label)
                <a href="{{ route('dashboard', ['range' => $value]) }}"
                    class="px-4 py-1.5 rounded-sm text-sm leading-normal border {{ $range === $value
                        ? 'bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] border-transparent'
                        : 'border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] dark:text-[#EDEDEC] dark:border-[#3E3E3A] dark:hover:border-[#62605b]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white dark:bg-[#161615] p-6 rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Transactions ({{ $rangeLabel }})</p>
            <p class="text-2xl font-medium mt-1">{{ number_format($totalTransactions) }}</p>
        </div>
        <div class="bg-white dark:bg-[#161615] p-6 rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Revenue ({{ $rangeLabel }})</p>
            <p class="text-2xl font-medium mt-1">Rp{{ number_format($totalRevenue, 2, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
        <div class="p-6 border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
            <h2 class="text-lg font-medium">Revenue - {{ $rangeLabel }}</h2>
        </div>
        <div class="p-6">
            <div class="flex items-end gap-1 h-48">
                @foreach ($chartValues as $index => $value)
                    <div class="flex-1 flex flex-col items-center justify-end h-full group">
                        <span class="text-[10px] text-[#706f6c] dark:text-[#A1A09A] mb-1 opacity-0 group-hover:opacity-100 transition">
                            {{ number_format($value, 0, ',', '.') }}
                        </span>
                        <div class="w-full rounded-t-sm bg-[#f53003] dark:bg-[#FF4433] min-h-[2px]"
                            style="height: {{ ($value / $maxValue) * 100 }}%"
                            title="{{ $chartLabels[$index] }}: Rp{{ number_format($value, 2, ',', '.') }}"></div>
                    </div>
                @endforeach
            </div>
            <div class="flex gap-1 mt-2">
                @foreach ($chartLabels as $label)
                    <div class="flex-1 text-center text-[10px] text-[#706f6c] dark:text-[#A1A09A] truncate">{{ $label }}</div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>