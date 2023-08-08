<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;


class OrderDYellow extends Model
{
    use HasFactory;

    protected $table            = 'order_d_yellow';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'time_id',
        'print_crew',
        'goods_rec',
        'boxes',
        'production_sample',
        'palletize',
        'palletize_opt',
        'in_hands',
        'design',
        'ship',
        'acct',
        'alpha',
        's_and_s',
        'sanmar',
        'is_rejected',
        'notes',
        'created_by_id',
        'created_by_name'
    ];

    public function Order(){
        return $this->belongsTo(Order::class, 'id','order_id');
    }
}
