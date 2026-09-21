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
        $timezone = $this->localTimezone();

        $range = $request->query('range', 'month');

        if (! array_key_exists($range, self::RANGE_LABELS)) {
            $range = 'month';
        }

        [$startDate, $endDate] = $this->resolveRange($range, $timezone);

        $query = fn () => Transaction::where('user_id', $userId)
            ->whereBetween('trx_date', [$startDate, $endDate]);

        $totalTransactions = $query()->count();
        $totalRevenue = $query()->sum('amount');
        $averageAmount = $query()->avg('amount');

        $offset = now($timezone)->format('P');

        $dailyTotals = $query()
            ->selectRaw("DATE(CONVERT_TZ(trx_date, '+00:00', ?)) as date, SUM(amount) as total", [$offset])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $dailyCounts = $query()
            ->selectRaw("DATE(CONVERT_TZ(trx_date, '+00:00', ?)) as date, COUNT(*) as count", [$offset])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $chartLabels = [];
        $chartValues = [];
        $chartCounts = [];
        $chartDates = [];

        $localStart = $startDate->copy()->setTimezone($timezone)->startOfDay();
        $localEnd = $endDate->copy()->setTimezone($timezone)->startOfDay();

        foreach (CarbonPeriod::create($localStart, $localEnd) as $date) {
            $key = $date->format('Y-m-d');

            $chartLabels[] = $date->format('d M');
            $chartValues[] = (float) ($dailyTotals[$key] ?? 0);
            $chartCounts[] = (int) ($dailyCounts[$key] ?? 0);
            $chartDates[] = $date->format('d M Y');
        }

        return view('dashboard', [
            'range' => $range,
            'rangeLabel' => self::RANGE_LABELS[$range],
            'totalTransactions' => $totalTransactions,
            'totalRevenue' => $totalRevenue,
            'averageAmount' => $averageAmount,
            'chartLabels' => $chartLabels,
            'chartValues' => $chartValues,
            'chartCounts' => $chartCounts,
            'chartDates' => $chartDates,
        ]);
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function resolveRange(string $range, string $timezone): array
    {
        $now = now($timezone);

        $endDate = $now->copy();

        $startDate = match ($range) {
            'today' => $now->copy()->startOfDay(),
            '7days' => $now->copy()->subDays(6)->startOfDay(),
            '30days' => $now->copy()->subDays(29)->startOfDay(),
            default => $now->copy()->startOfMonth(),
        };

        return [$startDate->utc(), $endDate->utc()];
    }

    private function localTimezone(): string
    {
        return config('app.local_timezone', 'Asia/Jakarta');
    }
}
