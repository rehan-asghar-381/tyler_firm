<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        "selector_ref",
        "variant_id",
        "variant_name",
        "attribute_id",
        "attribute_name",
        "created_at",
        "updated_at",
    ];

}
