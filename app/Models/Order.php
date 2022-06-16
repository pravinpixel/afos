<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_no',
        'payer_name',
        'payer_mobile_no',
        'student_id',
        'institute_id',
        'total_price',
        'status'
    ];

    public function student() {
        return $this->hasOne( Student::class, 'id', 'student_id' );
    }

    public function items() {
        return $this->hasMany( OrderItem::class);
    }

    public function payment() {
        return $this->hasOne(Transaction::class, 'order_id', 'id');
    }
}
