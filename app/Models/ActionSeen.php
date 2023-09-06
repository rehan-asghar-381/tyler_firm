<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmailLog;

class ActionSeen extends Model
{
    protected $table    = 'action_logs_seen';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email_log_id   ',
        'seen_by'
    ];

    public function EmailLog(){
        
        return $this->belongsTo(EmailLog::class, "email_log_id", "id");
    }

}
