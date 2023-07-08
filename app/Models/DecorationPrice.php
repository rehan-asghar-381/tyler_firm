<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DecorationPrice extends Model
{
    protected $table    = 'decoration_prices';
    protected $primary_key      = 'id';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value'
    ];
}
