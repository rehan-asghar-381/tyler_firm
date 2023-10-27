<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class NotificationConfig extends Model
{
    protected $table    = 'notificatios_config';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'time_id'
    ];


}
