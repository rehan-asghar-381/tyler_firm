<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;


class ProductVariant extends Model
{
    use HasFactory;

    protected $table            = 'product_variants';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [];

    public function Atrributes(){
        
        return $this->hasMany(ProductVariantAttribute::class, 'variant_id','id');
    }
    
    protected static function booted () {
        static::deleting(function(ProductVariant $ProductVariant) { 
            
             $ProductVariant->Atrributes()->delete();
        });
    }
    public function Product(){
        
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
