<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActionSeen;
use App\Models\orderCompFile;

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
    public function comp()
    {
        return $this->belongsTo(orderCompFile::class, 'comp_id', 'id');
    }
}
