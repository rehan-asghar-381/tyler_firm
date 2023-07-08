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
        'client_id',
        'first_name',
        'last_name',
        'phone_number',
        'phone_number',
        'title',
        'order_type',
        'field1_hb',
        'field2_b',
        'field3_w',
        'field4_hh',
        'field5_h',
        'field6_sh',
        'field7_half_sh',
        'field8_sh_w',
        'field9_sh_kn',
        'field10_sh_g',
        'field11_w_kn',
        'field12_w_g',
        'field13_arm',
        'field14_half_arm',
        'field15_arm_depth',
        'field16_bicep',
        'field17_wrist',
        'field18_sh_w',
        'field19_tw',
        'field20_sh_hh',
        'description',
        'order_date',
        'order_date_timestamp',
        'collection_date',
        'collection_date_timestamp',
        'tailor_comments',
        'time_id',
        'status',
        'created_by_id',
        'created_by_name',
        'updated_by_id',
        'updated_by_name',
    ];

    public function OrderSupply(){
        
        return $this->hasMany(OrderSupply::class, "order_id", "id");
    }

    public function OrderImgs(){
        
        return $this->hasMany(OrderImgs::class, "order_id", "id");
    }

    public function AdditionalFields(){
        
        return $this->hasMany(OrderAdditional::class, "order_id", "id");
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
