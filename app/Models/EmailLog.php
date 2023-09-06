<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActionSeen;

class EmailLog extends Model
{
    protected $table    = 'email_logs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     public function ActionSeen(){
        
        return $this->hasMany(ActionSeen::class, "email_log_id", "id");
    }
}
