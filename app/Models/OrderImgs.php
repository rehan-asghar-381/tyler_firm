<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;


class OrderImgs extends Model
{
    use HasFactory;

    protected $table            = 'order_imgs';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'image'
    ];

    public function Order(){

        return $this->belongsTo(Order::class, 'id','order_id');
    }


}
