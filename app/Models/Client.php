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
        'company_name',
        'reseller_number',
        'tax_examp',
    ];

    public function Orders(){
        
        return $this->hasMany(Order::class, "client_id", "id");
    }

    public function ClientDoc(){

        return $this->hasMany(ClientDoc::class, 'client_id','id');
    }
     public function ClientSaleRep(){

        return $this->hasMany(ClientSaleRep::class, 'client_id','id');
    }
}
