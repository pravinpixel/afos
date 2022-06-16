<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use DataTables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Students';
        if ($request->ajax()) {
            $data = Student::with('institute')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('institute', function($row){
                    return $row->institute->institute_code;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0);" class="action-icon" onclick="return view_modal('.$row->id.')"> <i class="mdi mdi-eye-outline"></i></a>';
                    return $btn;
                })
                ->rawColumns(['institute','action'])
                
                ->make(true);
        }
        return view('backend.students.index', compact('title'));
    }

    public function view(Request $request){
        $id = $request->id;
        $title = 'Student Information';
        $info = Student::find($id);
        return view('backend.students.view', compact('id', 'info', 'title'));
    }

    public function import_students() {
        return view('backend.students.import');
    }   

    public function import() 
    {
        Excel::import(new StudentImport,request()->file('file'));
        return response()->json(['error'=> 0, 'message' => 'Imported successfully']);
    }
}
