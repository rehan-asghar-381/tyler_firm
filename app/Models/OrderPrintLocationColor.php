<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPrintLocationColor extends Model
{
    use HasFactory;

    protected $table            = 'order_print_location_colors';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "order_id",
        "projected_units",
        "quantity_break",
        "size",
        "size_price",
        "location",
        "location_color",
        "created_at",
        "updated_at",

    ];

}
