<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Validator;
use Auth;
use DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Products';
        if ($request->ajax()) {
            $data = Product::with('category')->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('image', function($row){
                return '<img width="75" src="'.asset('products/'.$row->image).'">';
            })
                ->addColumn('category', function($row){
                    return $row->category->categories;
                })
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
                    <a href="javascript:void(0);" class="action-icon" onclick="return delete_product('.$row->id.')"> <i class="mdi mdi-delete"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status','image','category','action'])
                
                ->make(true);
        }
        return view('backend.products.index', compact('title'));
    }

    public function add_edit_modal(Request $request) {
        
        $title = 'Add Product';
        $category = ProductCategory::all();
        $id = $request->id;
        $info = '';
        if( isset( $id ) && !empty($id) ) {
            $title  = 'Update Product';
            $info   = Product::find($id);
        }
        return view('backend.products.add_edit', compact('title', 'category', 'id', 'info'));
    }

    public function save_role(Request $request) {
        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name,'.$id,
            'category' => 'required',
            'price' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->passes()) {
            
            if( $request->hasFile('image') ){
                $pro_image = time().'.'.$request->image->extension();  
                $request->image->move(public_path('products'), $pro_image);
                $ins['image'] = $pro_image;
            }

            $ins['name'] = $request->name;
            $ins['category_id'] = $request->category;
            $ins['price'] = $request->price;
            $ins['description'] = $request->description;
            $ins['status'] = 1;
            $info = Product::updateOrCreate(['id' => $id],$ins);
            
            $error = 0;
            $message = (isset($id) && !empty($id)) ? 'Updated Successfully' :'Added successfully';
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error'=> $error, 'message' => $message]);

    }

    public function delete_product(Request $request) {
        $id = $request->id;
        $info = Product::find($id);
        $info->delete();
        echo 1;
    }

    public function change_status(Request $request) {
        $id = $request->id;
        $status = $request->status;
        $info = Product::find($id);
        $info->status = $status;
        $info->update();
        echo 1;
    }
}
