<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSaleRep extends Model
{
    use HasFactory;

    protected $table            = 'client_sales_reps';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       
        "client_id",
        "first_name",
        "last_name",
        "email",
        "phone_number",


    ];
     
    public function Client(){

        return $this->belongsTo(Client::class, 'id','client_id');
    }


}
