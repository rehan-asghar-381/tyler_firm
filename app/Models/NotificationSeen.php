<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

class NotificationSeen extends Model
{
    protected $table    = 'seen_notificatins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notification_id',
        'seen_by_id'
    ];

    public function Notification(){
        
        return $this->belongsTo(Notification::class, "notification_id", "id");
    }

}
