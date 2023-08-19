<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOtherCharges extends Model
{
    use HasFactory;

    protected $table            = 'order_other_charges';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'fold_bag_tag_pieces',
        'fold_bag_tag_prices',
        'hang_tag_pieces',
        'hang_tag_prices',
        'label_pieces',
        'label_prices',
        'fold_pieces',
        'fold_pieces',
        'foil_pieces',
        'foil_prices',
        'palletizing_pieces',
        'palletizing_prices',
        'remove_packaging_pieces',
        'remove_packaging_prices',
        'art_fee',
        'art_discount',
        'art_time',
        'tax',
        'created_at',
        'updated_at',


    ];

}
