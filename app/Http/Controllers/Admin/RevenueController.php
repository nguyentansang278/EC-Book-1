<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Enums\OrderStatus;
use App\Services\Admin\RevenueServices;
use Carbon\Carbon;

class RevenueController extends Controller
{
    protected $revenueServices;

    public function __construct(RevenueServices $revenueServices)
    {
        $this->revenueServices = $revenueServices;
    }

    public function index(Request $request)
    {
        $timeFrame = $request->get('time_frame', 'day');
        $timeFrom = $request->get('time_from');
        $timeTo = $request->get('time_to');

        $sales = $this->revenueServices->getRevenueByTimeFrame($timeFrame, $timeFrom, $timeTo);

        switch ($timeFrame) {
            case 'day':
                $labels = $sales->pluck('day');
                break;
            case 'week':
                $labels = $sales->pluck('week');
                break;
            case 'month':
                $labels = $sales->map(function ($item) {
                    return Carbon::createFromFormat('Y-m', "{$item->year}-{$item->month}")->format('F Y');
                });
                break;
            case 'quarter':
                $labels = $sales->map(function ($item) {
                    return 'Q' . $item->quarter . ' ' . $item->year;
                });
                break;
            case 'year':
                $labels = $sales->pluck('year');
                break;
            default:
                $labels = collect();
                break;
        }

        $revenues = $sales->pluck('revenue');

        return view('admin.revenue.index', compact('labels', 'revenues', 'timeFrame', 'timeFrom', 'timeTo'));
    }
}
