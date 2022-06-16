<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Validator;
use Auth;
use DataTables;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Product Category';
        if ($request->ajax()) {
            $data = ProductCategory::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('status', function($row){
                    if( $row->status == 1){
                        $status = '<a href="javascript:void(0);" class="btn btn-success btn-sm" tooltip="Click to Inactive" onclick="return change_status('.$row->id.', 2)">Active</a>';
                    } else {
                        $status = '<a href="javascript:void(0);" class="btn btn-danger btn-sm" tooltip="Click to Active" onclick="return change_status('.$row->id.', 1)">Inactive</a>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0);" class="action-icon" onclick="return add_modal('.$row->id.')"> <i class="mdi mdi-square-edit-outline"></i></a>
                    <a href="javascript:void(0);" class="action-icon" onclick="return delete_category('.$row->id.')"> <i class="mdi mdi-delete"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('backend.productcategory.index', compact('title'));
    }

    public function add_edit_modal(Request $request) {
        $title = 'Add Product Category';
        $id = $request->id;
        $info = '';
        if( isset( $id ) && !empty( $id ) ) {
            $title = 'Update Product Category';
            $info = ProductCategory::find($id);
        }
        
        return view('backend.productcategory.add_edit', compact('title', 'info', 'id'));
    }

    public function save(Request $request) {
        $id = $request->id;
        
        $validator = Validator::make($request->all(), [
            'category' => 'required|unique:product_categories,categories,'.$id,
            'cutoff_start_time' => 'required',
            'cutoff_end_time' => 'required',
            'order' => 'required',
        ]);
        if ($validator->passes()) {
            $ins['categories'] = $request->category;
            $ins['cutoff_start_time'] = $request->cutoff_start_time;
            $ins['cutoff_end_time'] = $request->cutoff_end_time;
            $ins['description'] = $request->description;
            $ins['order'] = $request->order;
            $ins['status'] = 1;
            $info = ProductCategory::updateOrCreate(['id' => $id],$ins);
            $error = 0;
            $message = (isset($id) && !empty($id)) ? 'Updated Successfully' :'Added successfully';
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error'=> $error, 'message' => $message]);
    }

    public function delete(Request $request) {
        $id = $request->id;
        $info = ProductCategory::find($id);
        $info->delete();
        echo 1;
    }

    public function change_status(Request $request) {
        $id = $request->id;
        $status = $request->status;
        $info = ProductCategory::find($id);
        $info->status = $status;
        $info->update();
        echo 1;
    }
}
