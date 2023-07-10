<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderSupply;
use App\Models\Status;
use App\Models\OrderImgs;
use App\Models\OrderAdditional;
use App\Models\Job;
use App\Models\Client;
use App\Models\OrderTill;
use App\Models\SupplyInventoryItem;

class Order extends Model
{
    use HasFactory;

    protected $table            = 'orders';
    protected $primary_key      = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time_id',
        'client_id',
        'job_name',
        'order_number',
        'created_by_id',
        'created_by_name',
        'updated_by_id',
        'updated_by_name',
        'created_at',
        'updated_id'

    ];

    public function OrderSupply(){
        
        return $this->hasMany(OrderSupply::class, "order_id", "id");
    }

    public function OrderImgs(){
        
        return $this->hasMany(OrderImgs::class, "order_id", "id");
    }

    public function OrderProducts(){
        
        return $this->hasMany(OrderProduct::class, "order_id", "id");
    }
    public function OrderMargin(){
        
        return $this->hasMany(OrderMargin::class, "order_id", "id");
    }
    
     public function OrderProductVariant(){
        
        return $this->hasMany(OrderProductVariant::class, "order_id", "id");
    }
    public function OrderFinalPriceProductVariants(){
        
        return $this->hasMany(OrderFinalPriceProductVariants::class, "order_id", "id");
    }
    
     public function OrderPrintLocationColor(){
        
        return $this->hasMany(OrderPrintLocationColor::class, "order_id", "id");
    }

    public function Orderstatus(){
        
        return $this->belongsTo(Status::class, "status", "id");
    }

    public function OrderJobs(){
        
        return $this->hasMany(Job::class, "order_id", "id");
    }

    public function OrderType(){
        
        return $this->belongsTo(OrderType::class, "order_type", "id");
    }

    public function client(){
        
        return $this->belongsTo(Client::class, "client_id", "id");
    }
    public function OrderTill(){
        
        return $this->hasOne(OrderTill::class, "order_id", "id");
    }

}
