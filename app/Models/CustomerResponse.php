<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class CustomerResponse extends Model
{
    protected $table    = 'customer_responses';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time_id',
        'order_id',
        'client_id',
        'assignee_id',
        'assignee_name',
        'email',
        'remarks',
        'is_approved',
        'action'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

}
