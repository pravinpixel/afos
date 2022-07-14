<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DataTables;
use App\Models\Order;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Order Details';
        if ($request->ajax()) {
            $data = Order::orderBy('id', 'desc')->get();
            
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('date', function($row){
                    return date('d M Y, h:i A', strtotime($row->created_at));
                })
                ->addColumn('register_no', function($row){
                    return $row->student->register_no;
                })
                ->addColumn('board', function($row){
                    return $row->student->board;
                })
                ->addColumn('student', function($row){
                    return $row->student->name;
                })
                ->addColumn('status', function($row){
                    if( $row->status == 1){
                        $status = '<a href="javascript:void(0);" class="btn btn-success btn-sm" >Completed</a>';
                    } else if( $row->status == 2 ) {
                        $status = '<a href="javascript:void(0);" class="btn btn-warning btn-sm" >Pending</a>';
                    } else if( $row->status == 3 ) {
                        $status = '<a href="javascript:void(0);" class="btn btn-danger btn-sm" >Cancelled</a>';
                    } else if( $row->status == 4 ) {
                        $status = '<a href="javascript:void(0);" class="btn btn-danger btn-sm" >Failed</a>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    $btn = 'No Access';
                    if (check_user_access('orders', 'visible')) {
                        $btn = '<a href="javascript:void(0);" class="action-icon" onclick="return view_modal('.$row->id.')"> <i class="mdi mdi-eye-outline"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['date','register_no','board', 'student','status','action'])
                
                ->make(true);
        }
        return view('backend.orders.index', compact('title'));
    }

    public function view(Request $request) {
        $id = $request->id;
        $title = 'Order Information';
        $info = Order::find($id);
        return view('backend.orders.view', compact('id', 'info', 'title'));

    }
}
