<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;


class DYellowInkColor extends Model
{
    use HasFactory;
    protected $table            = 'order_d_yellow_ink_colors';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'time_id',
        'key',
        'location_number',
        'color_per_location',
        'ink_colors'
    ];

    public function Order(){
        return $this->belongsTo(Order::class, 'id','order_id');
    }
}
