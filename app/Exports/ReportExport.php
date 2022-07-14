<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Order;
use App\Models\Location;
use App\Models\Institution;
use App\Models\ProductCategory;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View {
        
        $range_date = $_POST['range_date'];
        $range_date = explode('-', $range_date);
        $from = date('Y-m-d',  strtotime( current($range_date) ) );
        $to = date('Y-m-d',  strtotime( end($range_date) ) );

        $report_type = $_POST['report_type'];
        $sub_type = $_POST['sub_type'];

        $records = DB::table('order_items as item')->select('orders.payer_name','orders.payer_mobile_no','orders.created_at as date', 'orders.status as order_status', 
                        'stu.register_no',
                        'loc.location_name as location','stu.board as board', 'stu.standard as class', 'stu.name as student',
                        'order_no', 'total_price', 'products.name as product_name', 'products.price as product_price', 
                        'cat.categories as food_type'                        
                        )
                    ->whereBetween(DB::raw('DATE(orders.created_at)'), array($from, $to))
                    ->join('orders', 'orders.id', '=', 'item.order_id')
                    ->join('institutions as ins', 'orders.institute_id', '=', 'ins.id')
                    ->join('locations as loc', 'ins.location_id', '=', 'loc.id')
                    ->join('students as stu', 'orders.student_id', '=', 'stu.id')
                    ->join('products', 'item.product_id', '=', 'products.id')
                    ->join('product_categories as cat', 'products.category_id', '=', 'cat.id')
                    ->when($report_type == 'location_wise', function ($q) use($sub_type) {
                        return $q->where('ins.location_id', $sub_type);
                    })
                    ->when($report_type == 'institute_wise', function ($q) use($sub_type) {
                        return $q->where('orders.institute_id', $sub_type);
                    })
                    ->when($report_type == 'class_wise', function ($q) use($sub_type) {
                        return $q->where('stu.standard', $sub_type);
                    }) 
                    ->when($report_type == 'order_status', function ($q) use($sub_type) {
                        return $q->where('orders.status', $sub_type);
                    }) 
                    ->when($report_type == 'food_wise', function ($q) use($sub_type) {
                        return $q->where('cat.id', $sub_type);
                    }) 
                    ->groupBy('item.id')
                    ->get();
        


        return view('exports.reports', ['list' => $records] );
    
        
    }
}
