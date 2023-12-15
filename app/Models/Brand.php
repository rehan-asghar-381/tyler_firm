<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\BrandImg;

class Brand extends Model
{
    protected $table    = 'brands';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time_id',
        'name',
        'description',
        'is_active',
        'created_by_id',
        'created_by_name',
        'updated_by_id',
        'updated_by_id'
    ];

    public function BrandImg(){

        return $this->hasMany(BrandImg::class, 'brand_id','id');
    }

}
