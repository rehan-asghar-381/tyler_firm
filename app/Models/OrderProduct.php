<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderSupply;
use App\Models\Status;
use App\Models\OrderImgs;
use App\Models\Client;
use App\Models\ProductVariant;
use App\Models\Product;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table            = 'order_products';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "order_id",
        "product_id",
        "selector_ref",
        "product_name",
        "created_at",
        "updated_at",


    ];

    public function OrderSupply(){
        
        return $this->hasMany(OrderSupply::class, "order_id", "id");
    }

    public function OrderImgs(){
        
        return $this->hasMany(OrderImgs::class, "order_id", "id");
    }

    public function Orderstatus(){
        
        return $this->belongsTo(Status::class, "status", "id");
    }

    public function OrderType(){
        
        return $this->belongsTo(OrderType::class, "order_type", "id");
    }

    public function client(){
        
        return $this->belongsTo(Client::class, "client_id", "id");
    }

    public function ProductVariant(){

        return $this->hasMany(ProductVariant::class, 'product_id','id');
    }

    public function OrderProductVariant(){

        return $this->hasMany(OrderProductVariant::class, 'product_id','product_id');
    }

    public function Product(){
        
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
