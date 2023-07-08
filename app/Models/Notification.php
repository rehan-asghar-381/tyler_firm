<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\NotificationSeen;

class Notification extends Model
{
    protected $table    = 'notifications';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idFK',
        'type',
        'added_by_id',
        'added_by_name',
        'body',
        'time_id'
    ];

    public function NotificationSeen(){
        
        return $this->hasOne(NotificationSeen::class, "notification_id", "id");
    }

}
