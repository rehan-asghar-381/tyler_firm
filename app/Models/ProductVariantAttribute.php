<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariant;


class ProductVariantAttribute extends Model
{
    use HasFactory;

    protected $table            = 'product_variant_attributes';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [];

    public function ProductVariant(){
            
        return $this->belongsTo(ProductVariant::class, 'variant_id','id');
    }
}
