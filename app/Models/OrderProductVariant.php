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
use App\Models\OrderTill;
use App\Models\SupplyInventoryItem;

class OrderProductVariant extends Model
{
    use HasFactory;

    protected $table            = 'order_product_variants';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "order_id",
        "product_id",
        "variant_id",
        "variant_name",
        "attribute_id",
        "attribute_name",
        "created_at",
        "updated_at",
    ];

}
