<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'institute_code',
        'location_id',
        'description',
        'is_default',
        'status'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
    public function students() {
        return $this->hasMany(Student::class, 'institute_id', 'id');
    }
    public function orders() {
        return $this->hasMany(Order::class, 'institute_id', 'id');
    }

    


}
