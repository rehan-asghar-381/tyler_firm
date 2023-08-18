<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMargin extends Model
{
    use HasFactory;

    protected $table            = 'order_margins';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      
        "order_id",
        "min_profit_margin",
        "max_profit_margin",
        "margin_size",
        "min_margin",
        "max_margin",
        "created_at",
        "updated_at",



    ];

}
