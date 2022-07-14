<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Validator;
use Auth;
use DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Users';
        if ($request->ajax()) {
            $data = User::with('role')->user()->latest()->get();
            
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('status', function($row){
                    if( $row->status == 1){
                        if (check_user_access('users', 'editable')) {
                            $status = '<a href="javascript:void(0);" class="btn btn-success btn-sm" tooltip="Click to Inactive" onclick="return change_status('.$row->id.', 2)">Active</a>';
                        } else {
                            $status = '<a href="javascript:void(0);" class="btn btn-success btn-sm" tooltip="Click to Inactive" >Active</a>';
                        }
                        
                    } else {
                        if (check_user_access('users', 'editable')) {
                            $status = '<a href="javascript:void(0);" class="btn btn-danger btn-sm" tooltip="Click to Active" onclick="return change_status('.$row->id.', 1)">Inactive</a>';
                        } else  {
                            $status = '<a href="javascript:void(0);" class="btn btn-danger btn-sm" tooltip="Click to Active" >Inactive</a>';
                        }
                    }
                    return $status;
                })
                ->addColumn('role', function($row){
                    return $row->role->name ?? '';
                })
                ->addColumn('action', function($row){
                    $edit_btn = '<a href="javascript:void(0);" class="action-icon" > <i class="mdi mdi-square-edit-outline"></i></a>';
                    $del_btn = '<a href="javascript:void(0);" class="action-icon" > <i class="mdi mdi-delete"></i></a>';

                    if (check_user_access('users', 'editable')) {
                        $edit_btn = '<a href="javascript:void(0);" class="action-icon" onclick="return add_modal('.$row->id.')"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    } 
                    if (check_user_access('users', 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" class="action-icon" onclick="return delete_user('.$row->id.')"> <i class="mdi mdi-delete"></i></a>';
                    }

                    return $edit_btn.$del_btn;
                })
                ->rawColumns(['role','action', 'status'])
                ->make(true);
        }
        return view('backend.user.index', compact('title'));
    }

    public function add_edit_modal(Request $request) {
        $title = 'Add Users';
        $id = $request->id;
        $info = '';
        $role = Role::where('status', 1)->get();
        if( isset( $id ) && !empty($id)) {
            $title = 'Update Users';
            $info = User::find($id);
        }
        return view('backend.user.add_edit', compact('title', 'id', 'info', 'role'));
    }

    public function save(Request $request) {
        $id = $request->id;
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile_no' => 'required|unique:users,mobile_no,'.$id,
            'role_id' => 'required',
        ]);
        if ($validator->passes()) {
            if( isset( $id ) && !empty($id)){
                
            } else {
                $ins['password'] = Hash::make($request->password);
            }
            if( $request->hasFile('image') ){
                $image_name     = time().'.'.$request->image->extension();  
                $request->image->move(public_path('images'), $image_name);
                $ins['image'] = $image_name;
            }
            $ins['name'] = $request->name;
            $ins['email'] = $request->email;
            $ins['mobile_no'] = $request->mobile_no;
            $ins['role_id'] = $request->role_id;
            $ins['status'] = 1;
            $info = User::updateOrCreate(['id' => $id],$ins);
            
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
        $info = User::find($id);
        $info->delete();
        echo 1;
    }

    public function change_status(Request $request) {
        $id = $request->id;
        $status = $request->status;
        $info = User::find($id);
        $info->status = $status;
        $info->update();
        echo 1;
    }
}
