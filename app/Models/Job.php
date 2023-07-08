<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;

class Job extends Model
{
    use HasFactory;

    protected $table            = 'assigned_jobs';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'tailor_id',
        'status_id',
        'start_date_time',
        'start_date_time_timestamp',
        'completion_date_time',
        'completion_date_time_timestamp',
        'assigend_by_id',
        'assigend_by_name',
        'updated_by_id',
        'updated_by_name',
        'status'
    ];

    public function Order(){
        
        return $this->belongsTo(Order::class, "order_id", "id");
    }

    public function Status(){
        
        return $this->belongsTo(Status::class, "status_id", "id");
    }

    public function User(){
        
        return $this->belongsTo(User::class, "tailor_id", "id");
    }


}
