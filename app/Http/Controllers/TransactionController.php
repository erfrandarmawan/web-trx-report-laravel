<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $timezone = config('app.local_timezone', 'Asia/Jakarta');

        $rangeStart = Carbon::parse($startDate, $timezone)->startOfDay()->utc();
        $rangeEnd = Carbon::parse($endDate, $timezone)->endOfDay()->utc();

        $transactions = Transaction::where('user_id', Auth::id())
            ->whereBetween('trx_date', [$rangeStart, $rangeEnd])
            ->orderBy('trx_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', compact('transactions', 'startDate', 'endDate'));
    }

    public function create(): View
    {
        return view('transactions.form', ['transaction' => null]);
    }

    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        Auth::user()->transactions()->create($request->validated());

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    public function edit(Transaction $transaction): View
    {
        Gate::authorize('update', $transaction);

        return view('transactions.form', compact('transaction'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        Gate::authorize('update', $transaction);

        $transaction->update($request->validated());

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        Gate::authorize('update', $transaction);

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
