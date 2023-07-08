<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImg;
use App\Models\Brand;
use App\Models\ProductVariant;

class Product extends Model
{
    protected $table    = 'products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time_id',
        'name',
        'code',
        'description',
        'quantity',
        'tax_rate_id',
        'cost',
        'inclusive_price',
        'gross_profit',
        'gross_profit_percentatge',
        'created_by_id',
        'created_by_name',
        'updated_by_id',
        'updated_by_id'
    ];

    public function ProductImg(){

        return $this->hasMany(ProductImg::class, 'product_id','id');
    }
    public function TaxRate(){

        return $this->belongsTo(TaxRate::class, 'tax_rate_id','id');
    }
    public function ProductVariant(){

        return $this->hasMany(ProductVariant::class, 'product_id','id');
    }
    public function Brand(){

        return $this->hasOne(Brand::class, 'id','brand_id');
    }

}
