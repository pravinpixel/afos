<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\Order;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $school = Institution::withCount('students')->get();
        $order_count = Order::where('status', 1)->count();
        $revenue = Order::where('status', 1)->sum('total_price');
        
        $category = DB::table('order_items')
                    // ->select(DB::raw('SUM(order_items.price) as total_sales,products.name'))
                    ->selectRaw('SUM(order_items.price) as total_sales,product_categories.categories')
                    ->join('products', 'products.id', '=', 'order_items.product_id')
                    ->join('orders', function($join){
                        $join->on('order_items.order_id', '=', 'orders.id')
                        ->where('orders.status', 1);
                    })
                    ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
                    ->groupBy('products.category_id')->get();
        
        return view('backend.dashboard.home', compact('school','order_count', 'revenue', 'category'));
    }
}
