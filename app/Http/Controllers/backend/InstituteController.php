<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\Location;
use Validator;
use Auth;
use DataTables;

class InstituteController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Institute';
        if ($request->ajax()) {
            $data = Institution::with('location')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('location', function($row){
                    return $row->location->location_name;
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
                    <a href="javascript:void(0);" class="action-icon" onclick="return delete_institute('.$row->id.')"> <i class="mdi mdi-delete"></i></a>';
                    return $btn;
                })
                ->rawColumns(['status','location','action'])
                
                ->make(true);
        }
        return view('backend.institute.index', compact('title'));
    }

    public function add_edit_modal(Request $request) {
        $title = 'Add Institute';
        $location = Location::where('status', 1)->get();
        $id = $request->id;
        $info = '';
        if( isset( $id ) && !empty($id) ) {
            $title  = 'Update Institute';
            $info   = Institution::find($id);
        }
        
        return view('backend.institute.add_edit', compact('title', 'info', 'id', 'location' ));
    }

    public function save(Request $request) {
        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'institute_code' => 'required|unique:institutions,institute_code,'.$id,
            'location_id' => 'required',
        ]);
        if ($validator->passes()) {
            $ins['name'] = $request->name;
            $ins['institute_code'] = $request->institute_code;
            $ins['location_id'] = $request->location_id;
            $ins['description'] = $request->description;
            $ins['status'] = 1;
            $info = Institution::updateOrCreate(['id' => $id],$ins);
            
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
        $info = Institution::find($id);
        $info->delete();
        echo 1;
    }

    public function change_status(Request $request) {
        $id = $request->id;
        $status = $request->status;
        $info = Institution::find($id);
        $info->status = $status;
        $info->update();
        echo 1;
    }
}
