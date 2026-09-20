<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $currentMonth = now()->startOfMonth();

        $totalTransactions = Transaction::where('user_id', $userId)
            ->where('trx_date', '>=', $currentMonth)
            ->count();

        $totalRevenue = Transaction::where('user_id', $userId)
            ->where('trx_date', '>=', $currentMonth)
            ->sum('amount');

        $averageAmount = Transaction::where('user_id', $userId)
            ->where('trx_date', '>=', $currentMonth)
            ->avg('amount');

        $recentTransactions = Transaction::where('user_id', $userId)
            ->latest('trx_date')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalTransactions',
            'totalRevenue',
            'averageAmount',
            'recentTransactions'
        ));
    }
}
