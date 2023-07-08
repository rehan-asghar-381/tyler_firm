<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\PaymentType;
use App\Models\Client;

class OrderTill extends Model
{
    use HasFactory;

    protected $table            = 'order_tills';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'client_id',
        'selling_price',
        'deposit',
        'balance',
        'payment_type',
        'created_by_id',
        'created_by_name'
    ];

    public function Order(){

        return $this->belongsTo(Order::class, 'order_id','id');
    }

    public function PaymentType(){

        return $this->belongsTo(PaymentType::class, 'payment_type','id');
    }

    public function Client(){

        return $this->belongsTo(Client::class, 'client_id','id');
    }
}
