<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * @var array<string, string>
     */
    private const RANGE_LABELS = [
        'today' => 'Today',
        '7days' => 'Last 7 Days',
        '30days' => 'Last 30 Days',
        'month' => 'This Month',
    ];

    public function index(Request $request): View
    {
        $userId = Auth::id();

        $range = $request->query('range', 'month');

        if (! array_key_exists($range, self::RANGE_LABELS)) {
            $range = 'month';
        }

        [$startDate, $endDate] = $this->resolveRange($range);

        $query = fn () => Transaction::where('user_id', $userId)
            ->whereBetween('trx_date', [$startDate, $endDate]);

        $totalTransactions = $query()->count();
        $totalRevenue = $query()->sum('amount');
        $averageAmount = $query()->avg('amount');

        $dailyTotals = $query()
            ->selectRaw('DATE(trx_date) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $chartLabels = [];
        $chartValues = [];

        foreach (CarbonPeriod::create($startDate->copy()->startOfDay(), $endDate->copy()->startOfDay()) as $date) {
            $chartLabels[] = $date->format('d M');
            $chartValues[] = (float) ($dailyTotals[$date->format('Y-m-d')] ?? 0);
        }

        return view('dashboard', [
            'range' => $range,
            'rangeLabel' => self::RANGE_LABELS[$range],
            'totalTransactions' => $totalTransactions,
            'totalRevenue' => $totalRevenue,
            'averageAmount' => $averageAmount,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
        ]);
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function resolveRange(string $range): array
    {
        $endDate = now();

        $startDate = match ($range) {
            'today' => now()->startOfDay(),
            '7days' => now()->subDays(6)->startOfDay(),
            '30days' => now()->subDays(29)->startOfDay(),
            default => now()->startOfMonth(),
        };

        return [$startDate, $endDate];
    }
}
