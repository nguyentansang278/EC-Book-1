<?php

namespace App\Services\Admin;

use App\Models\Order;
use Carbon\Carbon;
use App\Enums\OrderStatus;

class RevenueServices
{
    /**
     * 
     * @param string $timeFrame - 'day', 'month', 'year'
     * @return \Illuminate\Support\Collection
     */
    public function getRevenueByTimeFrame($timeFrame, $timeFrom, $timeTo)
    {
        $query = Order::completed();

        if ($timeFrom) {
            $startOfDay = Carbon::parse($timeFrom)->startOfDay();
            $query->where('created_at', '>=', $startOfDay);
        }
        if ($timeTo) {
            $endOfDay = Carbon::parse($timeTo)->endOfDay();
            $query->where('created_at', '<=', $endOfDay);
        }

        switch ($timeFrame) {
            case 'day':
                $query->selectRaw('DATE(created_at) as day, SUM(total_price) as revenue')
                      ->groupBy('day');
                break;

            case 'week':
                $query->selectRaw('WEEK(created_at) as week, YEAR(created_at) as year, SUM(total_price) as revenue')
                      ->groupBy('year', 'week');
                break;

            case 'month':
                $query->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_price) as revenue')
                      ->groupBy('year', 'month');
                break;

            case 'quarter':
                $query->selectRaw('QUARTER(created_at) as quarter, YEAR(created_at) as year, SUM(total_price) as revenue')
                      ->groupBy('year', 'quarter');
                break;

            case 'year':
                $query->selectRaw('YEAR(created_at) as year, SUM(total_price) as revenue')
                      ->groupBy('year');
                break;

            default:
                return collect([]);
        }

        return $query->get();
    }

    public function getWeeklySalesData()
    {
        $labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        $salesData = [
            'labels' => $labels,
            'thisWeek' => [],
            'lastWeek' => [],
            'totalSaleThisWeek' => 0,
        ];

        $today = Carbon::today();
        $startOfWeek = $today->startOfWeek();
        
        $startOfLastWeek = $startOfWeek->copy()->subWeek();

        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i);
            $lastWeekDay = $startOfLastWeek->copy()->addDays($i);

            $salesToday = $this->getSalesByDate($day);
            $salesLastWeek = $this->getSalesByDate($lastWeekDay);

            $salesData['thisWeek'][] = $salesToday;
            $salesData['lastWeek'][] = $salesLastWeek;

            $salesData['totalSaleThisWeek'] += $salesToday;
        }

        return $salesData;
    }

    private function getSalesByDate($date)
    {
        return Order::completed()->whereDate('created_at', $date)->sum('total_price');
    }
}