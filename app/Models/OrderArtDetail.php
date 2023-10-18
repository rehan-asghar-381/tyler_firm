<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;


class OrderArtDetail extends Model
{
    use HasFactory;

    protected $table            = 'order_art_detail';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'art_detail'
    ];

    public function Order(){

        return $this->belongsTo(Order::class, 'id','order_id');
    }


}
