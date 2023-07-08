<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\SupplyInventoryItem;

class OrderSupply extends Model
{
    use HasFactory;

    protected $table            = 'order_supplies';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'item_slug',
        'quantity'
    ];

    public function Order(){

        return $this->belongsTo(Order::class, 'id','order_id');
    }

    public function SupplyInventoryItem(){

        return $this->belongsTo(SupplyInventoryItem::class, 'item_slug','item_slug');
    }


}
