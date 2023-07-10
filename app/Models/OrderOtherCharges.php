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
        'art_fee',
        'art_discount',
        'art_time',
        'tax',
        'created_at',
        'updated_at',


    ];

}
