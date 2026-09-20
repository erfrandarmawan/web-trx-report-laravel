<x-layouts.app title="Transactions">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-medium">Transactions</h1>
        <div class="flex gap-2">
            <a href="{{ route('transactions.create') }}"
                class="inline-block px-5 py-1.5 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm leading-normal hover:bg-black dark:hover:bg-white">
                Create
            </a>
            <form method="GET" action="{{ route('transactions.export') }}">
                @foreach (['start_date' => $startDate, 'end_date' => $endDate] as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <button type="submit"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Export (.xlsx)
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="text-sm text-green-600 mb-4">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('transactions.index') }}"
        class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] p-6 mb-6 flex flex-wrap items-end gap-4">
        <div>
            <label for="start_date" class="block text-sm font-medium mb-1">Start Date</label>
            <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                class="px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
        </div>
        <div>
            <label for="end_date" class="block text-sm font-medium mb-1">End Date</label>
            <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                class="px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
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
                        <td class="px-6 py-3">Rp {{ number_format($transaction->amount, 2) }}</td>
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

        <div class="px-6 py-4">
            {{ $transactions->links() }}
        </div>
    </div>
</x-layouts.app>