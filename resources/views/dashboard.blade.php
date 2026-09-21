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

    <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between">
        <h1 class="text-xl font-medium sm:text-2xl">Dashboard - {{ auth()->user()->business_name }}</h1>

        <div class="grid grid-cols-2 gap-2 sm:flex sm:flex-wrap">
            @foreach ($ranges as $value => $label)
                <a href="{{ route('dashboard', ['range' => $value]) }}"
                    class="px-4 py-1.5 rounded-sm text-sm leading-normal text-center border {{ $range === $value
                        ? 'bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] border-transparent'
                        : 'border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] dark:text-[#EDEDEC] dark:border-[#3E3E3A] dark:hover:border-[#62605b]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2">
        <div class="bg-white dark:bg-[#161615] p-4 rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] sm:p-6">
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Transactions ({{ $rangeLabel }})</p>
            <p class="text-2xl font-medium mt-1">{{ number_format($totalTransactions) }}</p>
        </div>
        <div class="bg-white dark:bg-[#161615] p-4 rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] sm:p-6">
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Revenue ({{ $rangeLabel }})</p>
            <p class="text-2xl font-medium mt-1">Rp{{ number_format($totalRevenue, 2, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
        <div class="p-4 border-b border-[#e3e3e0] dark:border-[#3E3E3A] sm:p-6">
            <h2 class="text-lg font-medium">Revenue - {{ $rangeLabel }}</h2>
        </div>
        <div class="p-4 overflow-x-auto sm:p-6">
            <div class="min-w-[640px]">
                <div class="flex items-end gap-1 h-48">
                    @foreach ($chartValues as $index => $value)
                        <div class="chart-bar flex-1 flex flex-col items-center justify-end h-full group cursor-pointer"
                            data-date="{{ $chartDates[$index] }}"
                            data-amount="{{ $value }}"
                            data-count="{{ $chartCounts[$index] }}"
                            role="button" tabindex="0"
                            aria-label="{{ $chartDates[$index] }}: Rp{{ number_format($value, 2, ',', '.') }}, {{ $chartCounts[$index] }} transactions">
                            <span class="text-[10px] text-[#706f6c] dark:text-[#A1A09A] mb-1 opacity-0 group-hover:opacity-100 transition">
                                {{ number_format($value, 0, ',', '.') }}
                            </span>
                            <div class="w-full rounded-t-sm bg-[#f53003] dark:bg-[#FF4433] min-h-[2px] group-hover:bg-[#c62802] dark:group-hover:bg-[#e63524] transition-colors"
                                style="height: {{ ($value / $maxValue) * 100 }}%"></div>
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
    </div>

    <div id="chart-tooltip"
        class="fixed z-50 hidden pointer-events-none rounded-md bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] px-3 py-2 text-xs shadow-lg">
        <p class="font-medium mb-1" data-tooltip-date></p>
        <p data-tooltip-amount></p>
        <p data-tooltip-count></p>
    </div>

    <script>
        const tooltip = document.getElementById('chart-tooltip');
        const tooltipDate = tooltip.querySelector('[data-tooltip-date]');
        const tooltipAmount = tooltip.querySelector('[data-tooltip-amount]');
        const tooltipCount = tooltip.querySelector('[data-tooltip-count]');
        const formatRupiah = (value) => 'Rp' + Number(value).toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
        let activeBar = null;

        function showTooltip(bar) {
            const rect = bar.getBoundingClientRect();

            tooltipDate.textContent = bar.dataset.date;
            tooltipAmount.textContent = 'Total: ' + formatRupiah(bar.dataset.amount);
            tooltipCount.textContent = 'Transactions: ' + bar.dataset.count;

            tooltip.classList.remove('hidden');
            tooltip.style.visibility = 'hidden';

            const tipRect = tooltip.getBoundingClientRect();
            let left = rect.left + rect.width / 2 - tipRect.width / 2;
            left = Math.max(8, Math.min(left, window.innerWidth - tipRect.width - 8));

            let top = rect.top - tipRect.height - 8;

            if (top < 8) {
                top = rect.bottom + 8;
            }

            tooltip.style.left = left + 'px';
            tooltip.style.top = top + 'px';
            tooltip.style.visibility = 'visible';
        }

        function hideTooltip() {
            activeBar = null;
            tooltip.classList.add('hidden');
        }

        document.querySelectorAll('.chart-bar').forEach((bar) => {
            bar.addEventListener('click', () => {
                if (activeBar === bar) {
                    hideTooltip();
                    return;
                }

                activeBar = bar;
                showTooltip(bar);
            });

            bar.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    bar.click();
                }
            });
        });

        document.addEventListener('click', (event) => {
            if (! event.target.closest('.chart-bar')) {
                hideTooltip();
            }
        });

        window.addEventListener('scroll', hideTooltip, true);
        window.addEventListener('resize', hideTooltip);
    </script>
</x-layouts.app>