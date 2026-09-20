<x-layouts.app title="Dashboard">
    <h1 class="text-2xl font-medium mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-[#161615] p-6 rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Transactions (This Month)</p>
            <p class="text-2xl font-medium mt-1">{{ number_format($totalTransactions) }}</p>
        </div>
        <div class="bg-white dark:bg-[#161615] p-6 rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Revenue (This Month)</p>
            <p class="text-2xl font-medium mt-1">Rp {{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white dark:bg-[#161615] p-6 rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Average Transaction</p>
            <p class="text-2xl font-medium mt-1">Rp {{ number_format($averageAmount ?? 0, 2) }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
        <div class="p-6 border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
            <h2 class="text-lg font-medium">Recent Transactions</h2>
        </div>
        <div class="p-6">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-[#706f6c] dark:text-[#A1A09A]">
                        <th class="pb-3">Date</th>
                        <th class="pb-3">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentTransactions as $trx)
                        <tr class="border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                            <td class="py-2">{{ $trx->trx_date->format('Y-m-d H:i') }}</td>
                            <td class="py-2">Rp {{ number_format($trx->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-4 text-center text-[#706f6c] dark:text-[#A1A09A]">No transactions yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>