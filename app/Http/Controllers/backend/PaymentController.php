<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DataTables;
use App\Models\Transaction;
class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Payments';
        if ($request->ajax()) {
            $data = Transaction::orderBy('id', 'desc')->get();
            
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('date', function($row){
                    return date('d M Y, h:i A', strtotime($row->created_at));
                })
                ->addColumn('register_no', function($row){
                    return $row->order->student->register_no;
                })
                ->addColumn('order_no', function($row){
                    return $row->order->order_no;
                })
            
                ->addColumn('status', function($row){
                    if( $row->payment_status == 'success'){
                        $status = '<a href="javascript:void(0);" class="btn btn-success btn-sm" >Completed</a>';
                    }  else {
                        $status = '<a href="javascript:void(0);" class="btn btn-danger btn-sm" >Failed</a>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0);" class="action-icon" onclick="return view_modal('.$row->id.')"> <i class="mdi mdi-eye-outline"></i></a>';
                    return $btn;
                })
                ->rawColumns(['date','order_no','register_no','status','action'])
                
                ->make(true);
        }
        return view('backend.payments.index', compact('title'));
    }

    public function view(Request $request) {
        $id = $request->id;
        $title = 'Payment Information';
        $info = Transaction::find($id);
        return view('backend.payments.view', compact('id', 'info', 'title'));
    }
    
}
