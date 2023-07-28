<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class OrderPrice extends Model
{
    protected $table    = 'order_prices';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_size',
        'wholesale_price',
        'print_price',
        'total_price',
        'profit_margin',
        'final_price'
    ];
    public function Orders(){
        return $this->belongsTo(Order::class, "order_id", "id");
    }
    public function OrderColorPerLocation(){
        return $this->belongsTo(OrderColorPerLocation::class, "product_id", "product_id");
    }
}
