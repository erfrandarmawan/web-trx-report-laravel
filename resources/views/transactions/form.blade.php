<x-layouts.app :title="($transaction ? 'Edit' : 'Create').' Transaction'">
    <h1 class="text-2xl font-medium mb-6">{{ $transaction ? 'Edit Transaction' : 'Create Transaction' }}</h1>

    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] p-6 max-w-md">
        <form method="POST"
            action="{{ $transaction ? route('transactions.update', $transaction) : route('transactions.store') }}"
            class="space-y-4">
            @csrf
            @if ($transaction)
                @method('PUT')
            @endif

            <div>
                <label for="amount" class="block text-sm font-medium mb-1">Amount (Max 2 decimal digit)</label>
                <input type="number" name="amount" id="amount" step="0.01" min="0" value="{{ old('amount', $transaction?->amount) }}" required
                    class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                @error('amount')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="trx_date" class="block text-sm font-medium mb-1">Transaction Date</label>
                <input type="datetime-local" name="trx_date" id="trx_date" value="{{ old('trx_date', $transaction?->trx_date?->format('Y-m-d\TH:i') ?? now(config('app.local_timezone'))->format('Y-m-d\TH:i')) }}" required
                    onclick="this.showPicker()"
                    class="w-full px-3 py-2 border rounded-sm dark:bg-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                @error('trx_date')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm text-sm font-medium hover:bg-black dark:hover:bg-white">
                    Save
                </button>
                <a href="{{ route('transactions.index') }}"
                    class="inline-block px-5 py-2 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>