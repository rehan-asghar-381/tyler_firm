<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Client extends Model
{
    protected $table    = 'clients';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
    ];

    public function Orders(){
        
        return $this->hasMany(Order::class, "client_id", "id");
    }

}
