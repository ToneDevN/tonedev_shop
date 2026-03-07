<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('owner.dashboard', [
            'totalSales' => Order::where('status', 'completed')->sum('total_amount'),
            'newOrdersCount' => Order::where('status', 'pending')->count(),
            'totalProducts' => Product::count(),
        ]);
    }
}
