<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;


class ProductImg extends Model
{
    use HasFactory;

    protected $table            = 'product_images';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'image'
    ];

    public function Product(){

        return $this->belongsTo(Product::class, 'id','product_id');
    }


}
