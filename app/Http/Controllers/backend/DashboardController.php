<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\Student;
use DB;
use PDF;
class DashboardController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');
        
        $school = Institution::withCount('students')->get();
        $todayschool = Institution::with('orders.items')->withCount(['orders' => function($query) use($today){
                                        $query->whereDate('created_at', $today );
                                    }])->get();

        
      
        $food_category = ProductCategory::where('status', 1)->get();
        $class = Student::groupBy('standard')->get();

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
        
        return view('backend.dashboard.home', compact('school','order_count', 'revenue', 'category', 'food_category', 'class', 'todayschool'));
    }

    public function download_list(Request $request) {
        $institute_id = $request->institute_id;
        $order_date = $request->order_date;
        $download_type = $request->download_type;
        $category = $request->category;
        $food_category = ProductCategory::find($category);
        
        $info = Institution::find($institute_id);
        $total_order = get_order_item_count($institute_id, $order_date, $category ?? '')->count();
        if( $download_type == 'summary' ) {

            $items = DB::table('order_items')
                    ->selectRaw('product_categories.categories,students.standard,students.section, count(order_items.price) as item_count')
                    ->join('orders', 'orders.id', '=', 'order_items.order_id')
                    ->join('institutions', 'institutions.id', '=', 'orders.institute_id')
                    ->join('products', 'products.id', '=', 'order_items.product_id')
                    ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
                    ->join('students', 'students.id', '=', 'orders.student_id')
                    ->where( 'institutions.id', $institute_id)
                    ->whereDate('orders.created_at', $order_date )
                    ->when($category != '', function($query) use ($category){
                        $query->where('product_categories.id', $category);
                    })
                    ->groupBy('students.standard', 'students.section')
                    ->orderBy('students.standard')
                    ->orderBy('students.section')
                    ->get();

        } else {

            $items = DB::table('order_items')
                    ->selectRaw('products.name as product_name, students.name,students.register_no,product_categories.categories,students.standard,students.section, count(order_items.price) as item_count')
                    ->join('orders', 'orders.id', '=', 'order_items.order_id')
                    ->join('institutions', 'institutions.id', '=', 'orders.institute_id')
                    ->join('products', 'products.id', '=', 'order_items.product_id')
                    ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
                    ->join('students', 'students.id', '=', 'orders.student_id')
                    ->where( 'institutions.id', $institute_id)
                    ->whereDate('orders.created_at', $order_date )
                    ->when($category != '', function($query) use ($category) {
                        $query->where('product_categories.id', $category);
                    })
                    ->groupBy('students.id')
                    ->orderBy('students.standard')
                    ->orderBy('students.section')
                    ->orderBy('students.name')
                    ->dd();

        }

        $params = array( 'info' => $info, 'items' => $items, 'total_order' => $total_order, 'order_date' => $order_date, 'food_category' => $food_category);

        // return view('backend.dashboard._summary_list', $params);
        // die;
        $pdf = PDF::loadView('backend.dashboard._'.$download_type.'_list', $params);
        $path = public_path('pdf/');
        $fileName =  time().'.'. 'pdf' ;
        $pdf->save($path . '/' . $fileName);

        $pdf = public_path('pdf/'.$fileName);
        return response()->download($pdf);
    }

    public function get_orders_count(Request $request) {
        $order_date = $request->order_date;
        $category_id = $request->category;
        
        $school = Institution::where('status', 1)->get();
        $res = [];
        if( isset( $school ) && !empty($school)) {
            foreach ($school as $key => $value) {
                $tmp = [];
                $info = get_order_item_count($value->id, $order_date, $category_id);                
                $tmp = array('id' => $value->id, 'count' => $info->count());
                $res[] = $tmp;
            }
        }

        return $res;
    }

    public function manifest() {
        $school = Institution::where('status', 1)->get();
        $food_category = ProductCategory::where('status', 1)->get();
        return view('backend.manifest.index', compact('school', 'food_category'));
    }
}
