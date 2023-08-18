<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderContractPrintPrice extends Model
{
    use HasFactory;

    protected $table            = 'order_contract_print_prices';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'location_charge',
        'location_charge_price',
        'size',
        'size_total_price',
        'created_at',
        'updated_at',

    ];

}
