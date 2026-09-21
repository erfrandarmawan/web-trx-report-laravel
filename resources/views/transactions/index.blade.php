<x-layouts.app :title="'Transactions - ' . auth()->user()->business_name">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl font-medium">Transactions - {{ auth()->user()->business_name }}</h1>

        <a href="{{ route('transactions.create') }}"
            class="inline-block px-5 py-1.5 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm leading-normal hover:bg-black dark:hover:bg-white">
            Create
        </a>
    </div>

    @if (session('success'))
        <div class="text-sm text-green-600 mb-4">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('transactions.index') }}"
        class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] p-6 mb-6 flex flex-wrap items-end gap-4">
        <div>
            <label for="start_date" class="block text-sm font-medium mb-1">Date Range</label>
            <div class="flex items-center border border-[#19140035] dark:border-[#3E3E3A] rounded-sm dark:bg-[#1b1b18]">
                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                    class="px-3 py-2 bg-transparent text-sm dark:text-[#EDEDEC] focus:outline-none">
                <span class="px-1 text-[#706f6c] dark:text-[#A1A09A]">&ndash;</span>
                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                    class="px-3 py-2 bg-transparent text-sm dark:text-[#EDEDEC] focus:outline-none">
            </div>
        </div>
        <button type="submit"
            class="px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium hover:bg-black dark:hover:bg-white">
            Filter
        </button>
    </form>

    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-[#706f6c] dark:text-[#A1A09A] border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Amount</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                        <td class="px-6 py-3">{{ $transaction->trx_date->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-3">Rp{{ number_format($transaction->amount, 2, ',', '.') }}</td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('transactions.edit', $transaction) }}" class="text-[#f53003] dark:text-[#FF4433] underline underline-offset-4">Edit</a>
                            <form method="POST" action="{{ route('transactions.destroy', $transaction) }}"
                                onsubmit="return confirm('Are you sure you want to delete this transaction?');"
                                class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[#f53003] dark:text-[#FF4433] underline underline-offset-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-[#706f6c] dark:text-[#A1A09A]">No transactions in this date range.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($transactions->hasPages())
            <div class="px-6 py-4 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                {{ $transactions->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <script>
        document.querySelectorAll('#start_date, #end_date').forEach((input) => {
            input.addEventListener('click', () => {
                try {
                    input.showPicker();
                } catch (e) {}
            });
        });
    </script>
</x-layouts.app>