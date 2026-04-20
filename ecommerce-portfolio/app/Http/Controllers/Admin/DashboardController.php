<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalRevenue   = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders    = Order::count();
        $pendingOrders  = Order::where('status', 'pending')->count();
        $totalProducts  = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalUsers     = User::count();

        $recentOrders = Order::latest()->limit(6)->get();

        // Role distribution
        $usersByRole = User::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        return view('admin.dashboard', compact(
            'user',
            'totalRevenue',
            'totalOrders',
            'pendingOrders',
            'totalProducts',
            'activeProducts',
            'totalUsers',
            'recentOrders',
            'usersByRole',
        ));
    }
}
