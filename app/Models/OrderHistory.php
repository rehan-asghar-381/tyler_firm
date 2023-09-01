<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table    = 'order_history';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time_id',
        'order_id',
        'email',
        'remarks',
        'is_approved'
    ];
}
