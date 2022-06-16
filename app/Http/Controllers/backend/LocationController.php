<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use Validator;
use Auth;
use DataTables;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Locations';
        if ($request->ajax()) {
            $data = Location::all();
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
                    <a href="javascript:void(0);" class="action-icon" onclick="return delete_location('.$row->id.')"> <i class="mdi mdi-delete"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('backend.location.index', compact('title'));
    }

    public function add_edit_modal(Request $request) {
        $title = 'Add Locations';
        $id = $request->id;
        $info = '';
        if( isset( $id ) && !empty( $id ) ) {
            $title = 'Update Locations';
            $info = Location::find($id);
        }
        return view('backend.location.add_edit', compact('title', 'info', 'id'));
    }

    public function save(Request $request) {
        $id = $request->id;
        
        $validator = Validator::make($request->all(), [
            'location_name' => 'required|unique:locations,location_name,'.$id,
        ]);
        if ($validator->passes()) {
            $ins['location_name'] = $request->location_name;
            $ins['address'] = $request->description;
            $ins['status'] = 1;
            $info = Location::updateOrCreate(['id' => $id],$ins);
            
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

        $info = Location::find($id);
        $info->delete();
        echo 1;
    }

    public function change_status(Request $request) {
        $id = $request->id;
        $status = $request->status;
        $info = Location::find($id);
        $info->status = $status;
        $info->update();
        echo 1;
    }

    
}
