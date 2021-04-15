<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PlanSubscription;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    /**
     * Display Super Admin Dashboard Page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get()->count();
        $active_subscriptions = PlanSubscription::findActive()->get()->count();
        $total_earnings = Order::all()->sum('price');
        $latest_orders = Order::take(10)->latest()->get();

        // Create Period from given dates
        $dateStarts = Carbon::now()->subMonth(12)->startOfMonth();
        $dateEnds = Carbon::now()->endOfMonth();
        $period = CarbonPeriod::since($dateStarts)->months(1)->until($dateEnds);

        // Arrays for Expenses Chart
        $earnings_stats_label = [];
        $earnings_stats = [];

        // Iterate over the Date Period 
        foreach ($period as $date) {
            // Add month as label
            $month = $date->format('M');
            array_push($earnings_stats_label, $month);

            // Add Earning amount for current month
            $earning = Order::get(['price', 'created_at'])
                ->whereBetween('created_at', [$date->format('Y-m-d'), $date->endOfMonth()->format('Y-m-d')])
                ->sum('price');
            array_push($earnings_stats, $earning/100);
        }

        return view('super_admin.dashboard.index', [
            'users' => $users,
            'active_subscriptions' => $active_subscriptions,
            'total_earnings' => $total_earnings,
            'earnings_stats_label' => $earnings_stats_label,
            'earnings_stats' => $earnings_stats,
            'latest_orders' => $latest_orders,
        ]);
    }
}
