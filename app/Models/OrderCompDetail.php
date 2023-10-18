<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;


class OrderCompDetail extends Model
{
    use HasFactory;

    protected $table            = 'order_comp_comments';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'comp_detail',
        'added_by',
        'added_by_role'
    ];

    public function Order(){

        return $this->belongsTo(Order::class, 'id','order_id');
    }


}
