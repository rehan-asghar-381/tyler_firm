<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;


class BrandImg extends Model
{
    use HasFactory;

    protected $table            = 'brand_images';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'image'
    ];

    public function Brand(){

        return $this->belongsTo(Brand::class, 'id','brand_id');
    }


}
