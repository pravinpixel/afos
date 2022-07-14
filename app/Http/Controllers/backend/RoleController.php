<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Validator;
use Auth;
use DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Roles';
        if ($request->ajax()) {
            $data = Role::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('status', function($row){
                    if( $row->status == 1){
                        if (check_user_access('roles', 'editable')) {
                            $status = '<a href="javascript:void(0);" class="btn btn-success btn-sm" tooltip="Click to Inactive" onclick="return change_status('.$row->id.', 2)">Active</a>';
                        } else {
                            $status = '<a href="javascript:void(0);" class="btn btn-success btn-sm" tooltip="Click to Inactive" >Active</a>';
                        }
                    } else {
                        if (check_user_access('roles', 'editable')) {
                            $status = '<a href="javascript:void(0);" class="btn btn-danger btn-sm" tooltip="Click to Active" onclick="return change_status('.$row->id.', 1)">Inactive</a>';
                        } else {
                            $status = '<a href="javascript:void(0);" class="btn btn-danger btn-sm" tooltip="Click to Active" >Inactive</a>';
                        }
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    $edit_btn = '<a href="javascript:void(0);" class="action-icon" > <i class="mdi mdi-square-edit-outline"></i></a>';
                    $del_btn = '<a href="javascript:void(0);" class="action-icon" > <i class="mdi mdi-delete"></i></a>';
                    if (check_user_access('roles', 'editable')) {
                        $edit_btn = '<a href="javascript:void(0);" class="action-icon" onclick="return add_modal('.$row->id.')"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    }
                    if (check_user_access('roles', 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" class="action-icon" onclick="return delete_institute('.$row->id.')"> <i class="mdi mdi-delete"></i></a>';
                    }
                   
                    return $edit_btn.$del_btn;
                })
                ->rawColumns(['action', 'status'])
                
                ->make(true);
        }
        return view('backend.role.index', compact('title'));
    }

    public function add_edit_modal(Request $request) {
        $title = 'Add Roles';
        $info = '';
        $id = $request->id;
        if( isset( $id ) && !empty($id)){
            $title = 'Update Roles';
            $info = Role::find($id);
        }
        return view('backend.role.add_edit', compact('title', 'id', 'info'));
    }

    public function save(Request $request) {
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$id,
        ]);
        if ($validator->passes()) {
            $perm = [];
            if( config('constant.permission') ) {
                foreach (config('constant.permission') as $item) {
                    $perm[$item] = array(
                        $item.'_visible' => $_POST[$item.'_visible'] ?? 'off',
                        $item.'_editable' => $_POST[$item.'_editable'] ?? 'off',
                        $item.'_delete' => $_POST[$item.'_delete'] ?? 'off',
                    );
                }
            }
            
            $ins['name'] = $request->name;
            $ins['description'] = $request->description;
            $ins['permissions'] = serialize($perm);
            $ins['status'] = 1;
            
            $info = Role::updateOrCreate(['id' => $id],$ins);
            
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
        $info = Role::find($id);
        $info->delete();
        echo 1;
    }

    public function change_status(Request $request) {
        $id = $request->id;
        $status = $request->status;
        $info = Role::find($id);
        $info->status = $status;
        $info->update();
        echo 1;
    }
}
