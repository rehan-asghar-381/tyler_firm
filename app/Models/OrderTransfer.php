<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransfer extends Model
{
    use HasFactory;

    protected $table            = 'order_transfer';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      
        'order_id',
        'transfers_pieces',
        'transfers_prices',
        'ink_color_change_pieces',
        'art_discount_prices',
        'created_at',
        'updated_at',

    ];

}
