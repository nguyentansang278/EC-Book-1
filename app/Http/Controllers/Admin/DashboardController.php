<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Enums\OrderStatus;
use Awssat\Visits\Visits;
use App\Services\Admin\RevenueServices;

class DashboardController extends Controller
{
    protected $revenueServices;

    public function __construct(RevenueServices $revenueServices)
    {
        $this->revenueServices = $revenueServices;
    }

    public function index()
    {
        $visitorsData = [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
            'currentWeek' => [120, 129, 125, 140, 155, 200, 190],
            'lastWeek' => [100, 119, 119, 120, 129, 140, 170],
            'totalCurrentWeek' => 0,
        ];

        $visitorsData['totalCurrentWeek'] = array_sum($visitorsData['currentWeek']);

        $salesData = $this->revenueServices->getWeeklySalesData();

        return view('admin.dashboard', compact('visitorsData', 'salesData'));
    }
}
