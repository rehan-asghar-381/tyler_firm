<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderSupply;
use App\Models\Status;
use App\Models\OrderImgs;
use App\Models\OrderAdditional;
use App\Models\Job;
use App\Models\Client;

class OrderFinalPriceProductVariants extends Model
{
    use HasFactory;

    protected $table            = 'order_final_price_product_variants';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      
        'order_id',
        'product_id',
        'variant_id',
        'variant_name',
        'attribute_id',
        'attribute_name',
        'price',
        'created_at',
        'updated_at',


    ];

}
