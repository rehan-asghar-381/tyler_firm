<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;


class OrderAdditional extends Model
{
    use HasFactory;

    protected $table            = 'order_additional';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'label',
        'value'
    ];

    public function Order(){

        return $this->belongsTo(Order::class, 'id','order_id');
    }


}
