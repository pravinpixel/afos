<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'categories',
        'description',
        'cutoff_start_time',
        'cutoff_end_time',
        'order',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id')->where('status', 1);
    }

    public function scopeCutoff($query){
        $time = date('H:i:s');
        return $query->where('cutoff_start_time', '<=', $time )->where('cutoff_end_time', '>=', $time );


    }
}
