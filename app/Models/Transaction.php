<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transaction_no',
        'payment_type',
        'amount',
        'payment_status',
        'description',
        'response'
    ];

    public function order() {
        return $this->hasOne( Order::class, 'id', 'order_id' );
    }


}
