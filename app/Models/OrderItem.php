<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'status'
    ];

    public function product() {
        return $this->hasOne( Product::class, 'id', 'product_id' );
    }

    public function Order() {
        return $this->hasOne( Order::class, 'id', 'order_id' );
    }
}
