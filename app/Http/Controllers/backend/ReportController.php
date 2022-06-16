<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Order;
use App\Models\Location;
use App\Models\Institution;
use App\Models\ProductCategory;
use App\Models\Student;
use DB;

class ReportController extends Controller
{
    public function index(Request $request) {

        if ($request->ajax()) {

            $draw            = $request->get('draw');
            $start           = $request->get("start");
            $rowperpage      = $request->get("length");
            $columnIndex_arr = $request->get('order');
            $columnName_arr  = $request->get('columns');
            $order_arr       = $request->get('order');
            $search_arr      = $request->get('search');
            // $columnIndex     = $columnIndex_arr[0]['column'];
            // $columnName      = $columnName_arr[$columnIndex]['data'];
            // $columnSortOrder = $order_arr[0]['dir'];
            $searchValue     = $search_arr['value'];

            $range_date = $request->range_date;
            $range_date = explode('-', $range_date);
            $from = date('Y-m-d',  strtotime( current($range_date) ) );
            $to = date('Y-m-d',  strtotime( end($range_date) ) );

            $report_type = $request->report_type;
            $sub_type = $request->sub_type;

            $totalRecords = Order::whereBetween(DB::raw('DATE(orders.created_at)'), array($from, $to))
                    ->join('institutions as ins', 'orders.institute_id', '=', 'ins.id')
                    ->join('students as stu', 'orders.student_id', '=', 'stu.id')
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
                    // ->when(!empty($searchValue), function($q) use($searchValue){
                    //     $q->where('products.name', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('categories.name', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('brands.title', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('product_types.name', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('vendor_products.qty', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('vendor_products.price', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('products.code', 'like', '%' .$searchValue. '%');
                    // })                  
                    ->orderBy('orders.id', 'desc')
                    ->count();


            $records = Order::select('orders.created_at as date', 'orders.status as order_status', 
                        'stu.register_no',
                        'loc.location_name as location','stu.board as board', 'stu.standard as class', 'stu.name as student',
                        'order_no', 'total_price'
                        )
                    ->whereBetween(DB::raw('DATE(orders.created_at)'), array($from, $to))
                    ->join('institutions as ins', 'orders.institute_id', '=', 'ins.id')
                    ->join('locations as loc', 'ins.location_id', '=', 'loc.id')
                    ->join('students as stu', 'orders.student_id', '=', 'stu.id')
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
                    // ->when(!empty($searchValue), function($q) use($searchValue){
                    //     $q->where('products.name', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('categories.name', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('brands.title', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('product_types.name', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('vendor_products.qty', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('vendor_products.price', 'like', '%' .$searchValue. '%')
                    //     ->orWhere('products.code', 'like', '%' .$searchValue. '%');
                    // })                  
                    // ->orderBy($columnName,$columnSortOrder)
                    ->skip($start)
                    ->take($rowperpage == -1 ? $totalRecords : $rowperpage)
                    ->get();

            
            $data_arr = array();
            foreach($records as $row){

                $food_type = '';
                if( isset($row->items) && !empty( $row->items) ){
                    foreach ($row->items as $key => $value) {
                        $food_type .= '<div>'.$value->product->category->categories.'</div>';
                    }
                }

                $food = '';
                if( isset($row->items) && !empty( $row->items) ){
                    foreach ($row->items as $key => $value) {
                        $food .= '<div>'.$value->product->name.' : ' .$value->product->price.'</div>';
                    }
                }

                $status = '';
                    
                if( $row->order_status == 1){
                    $status = '<a href="javascript:void(0);" class="text-success" >Completed</a>';
                } else if( $row->order_status == 2 ) {
                    $status = '<a href="javascript:void(0);" class="text-warning" >Pending</a>';
                } else if( $row->order_status == 3 ) {
                    $status = '<a href="javascript:void(0);" class="text-danger" >Cancelled</a>';
                } else if( $row->order_status == 4 ) {
                    $status = '<a href="javascript:void(0);" class="text-danger" >Failed</a>';
                }
                
                $data_arr[] = array(
                    'date' => date('d M Y, h:i A', strtotime($row->date)),
                    'register_no' => $row->register_no,
                    'location' => $row->location,
                    'board' => $row->board,
                    'class' => $row->class,
                    'student' => $row->student,
                    'order_no' => $row->order_no,
                    'total_price' => $row->total_price,
                    'food_type' => $food_type,
                    'food' => $food,
                    'order_status' => $status,
                );
            }
            $response = array(
                "draw" => intval($draw),
                "recordsTotal" => $records->count(),
                "recordsFiltered" => $totalRecords,
                "aaData" => $data_arr
            );
            return json_encode($response);
        }

        return view('backend.reports.index');
    }

    public function get_subtypes(Request $request) {
        $report_type = $request->report_type;
        $option = '<option value=""> All</option>';

        if( $report_type == 'location_wise') {
            $location = Location::where('status', 1)->get();
            if( isset( $location ) && !empty( $location )) {
                foreach ($location as $item ) {
                    $option .= '<option value="'.$item->id.'">'.$item->location_name.'</option>';
                }
            }
        } else if( $report_type == 'institute_wise' ) {
            $institute = Institution::where('status', 1)->get();
            if( isset( $institute ) && !empty( $institute )) {
                foreach ($institute as $item ) {
                    $option .= '<option value="'.$item->id.'">'.$item->name.'( '.$item->institute_code.' )</option>';
                }
            }
        } else if( $report_type == 'class_wise' ) {
            $class = Student::groupBy('standard')->get();
            if( isset( $class ) && !empty( $class )) {
                foreach ($class as $item ) {
                    $option .= '<option value="'.$item->standard.'">'.$item->standard.'</option>';
                }
            }
        } else if( $report_type == 'food_wise' ) {
            $categ = ProductCategory::where('status', '1')->orderBy('categories')->get();
            if( isset( $categ ) && !empty( $categ )) {
                foreach ($categ as $item ) {
                    $option .= '<option value="'.$item->id.'">'.$item->categories.'</option>';
                }
            }
        } else if( $report_type == 'order_status' ) {
            $option .= '<option value="1">Completed</option>';
            $option .= '<option value="2">Pending</option>';
            $option .= '<option value="3">Cancelled</option>';
            $option .= '<option value="4">Failed</option>';
        }

        return $option;

    }
}
