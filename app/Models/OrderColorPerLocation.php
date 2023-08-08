<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;

class OrderColorPerLocation extends Model
{
    protected $table    = 'order_color_per_locations';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'location_number',
        'color_per_location'
    ];
    public function Orders(){
        return $this->belongsTo(Order::class, "order_id", "id");
    }
    public function OrderPrice(){
        return $this->belongsTo(OrderPrice::class, "product_id", "product_id");
    }
    public function Product(){
        return $this->belongsTo(Product::class, "product_id", "id");
    }

    
}
