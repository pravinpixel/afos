<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Institution;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel,WithHeadingRow
{
    
    public function model(array $row)
    {
        
        $ins_info = Institution::where('institute_code', $row['board'])->first();
         
        return new Student([
            'institute_id' => $ins_info->id ?? null,
            'board' => $row['board'],
            'register_no' => $row['regno'],
            'standard' => $row['std'],
            'section' => $row['sec'],
            'name' => $row['name'],
            'dob' => date('Y-m-d', strtotime($row['dob'])),
            'parents_name' => $row['parents'],
            'contact_no' => $row['contact'] ?? null
        ]);
    }
}
