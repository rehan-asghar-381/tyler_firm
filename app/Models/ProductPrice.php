<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariantAttribute;

class ProductPrice extends Model
{
    use HasFactory;

    protected $table            = 'product_prices';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      
        "product_id",
        "v1_id",
        "v1_attr_id",
        "v2_id",
        "v2_attr_id",
        "price",
        "created_by_id",
        "created_by_name",
        "created_at",
        "updated_at",


    ];

    public function v2AttrName(){

        return $this->belongsTo(ProductVariantAttribute::class, 'v2_attr_id','id');
    }

}
