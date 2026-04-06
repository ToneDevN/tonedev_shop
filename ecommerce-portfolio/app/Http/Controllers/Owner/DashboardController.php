<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();

        $totalSales    = Order::where('status', 'completed')->sum('total_amount');
        $newOrdersCount = Order::where('status', 'pending')->count();
        $totalProducts = Product::count();

        $recentOrders  = Order::latest()->limit(5)->get();

        // สรุปสถานะ order ทั้งหมด
        $orderStatusSummary = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // ยอดขายรายเดือน 6 เดือนล่าสุด
        $thaiMonths = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
        $monthlySalesRaw = Order::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, SUM(total_amount) as total")
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $salesLabels = [];
        $salesData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $salesLabels[] = $thaiMonths[$m->month - 1];
            $salesData[]   = (float) ($monthlySalesRaw[$m->format('Y-m')] ?? 0);
        }

        return view('owner.dashboard', compact(
            'user',
            'totalSales',
            'newOrdersCount',
            'totalProducts',
            'recentOrders',
            'orderStatusSummary',
            'salesLabels',
            'salesData',
        ));
    }
}
