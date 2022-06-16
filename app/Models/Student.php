<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'institute_id',
        'board',
        'register_no',
        'standard',
        'section',
        'name',
        'dob',
        'parents_name',
        'contact_no',
        'address'
    ];

    public function institute()
    {
        return $this->belongsTo(Institution::class, 'institute_id', 'id');
    }

    public function school()
    {
        return $this->hasOne(Institution::class, 'institute_id', 'id');
    }
}
