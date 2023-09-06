<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Status;
use App\Models\OrderImgs;
use App\Models\Client;
use App\Models\OrderOtherCharges;
use App\Models\OrderPrice;
use App\Models\OrderColorPerLocation;
use App\Models\OrderTransfer;
use App\Models\DYellowInkColor;
use App\Models\OrderHistory;
use App\Models\EmailLog;

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
        'projected_units',
        'sales_rep',
        'due_date',
        'ship_date',
        'event',
        'shipping_address',
        'notes',
        'notes',
        'created_by_id',
        'created_by_name',
        'updated_by_id',
        'updated_by_name',
        'created_at',
        'updated_id'

    ];

    public function OrderPrice(){
        
        return $this->hasMany(OrderPrice::class, "order_id", "id");
    }

    public function OrderColorPerLocation(){

        return $this->hasMany(OrderColorPerLocation::class, "order_id", "id");
    }
    public function OrderImgs(){
        
        return $this->hasMany(OrderImgs::class, "order_id", "id");
    }
    public function OrderHistory(){
        
        return $this->hasMany(OrderHistory::class, "order_id", "id");
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
    public function EmailLog(){
        
        return $this->hasMany(EmailLog::class, "order_id", "id");
    }
    public function ActionSeen(){
        
        return $this->hasMany(ActionSeen::class, "order_id", "id");
    }
    public function OrderPrintLocationColor(){
        
        return $this->hasMany(OrderPrintLocationColor::class, "order_id", "id");
    }

    public function Orderstatus(){
        
        return $this->belongsTo(Status::class, "status", "id");
    }
    public function QuoteApproval(){
        
        return $this->belongsTo(QuoteApproval::class, "quote_approval", "id");
    }
    public function Blank(){
        
        return $this->belongsTo(Blank::class, "blank", "id");
    }

    public function OrderJobs(){
        
        return $this->hasMany(Job::class, "order_id", "id");
    }
    public function DYellowInkColors(){
        
        return $this->hasMany(DYellowInkColor::class, "order_id", "id");
    }

    public function OrderType(){
        
        return $this->belongsTo(OrderType::class, "order_type", "id");
    }

    public function client(){
        
        return $this->belongsTo(Client::class, "client_id", "id");
    }
    public function OrderTransfer(){
        
        return $this->hasOne(OrderTransfer::class, "order_id", "id");
    }
    public function OrderOtherCharges(){
        
        return $this->hasOne(OrderOtherCharges::class, "order_id", "id");
    }
    public function ClientSaleRep(){
        
        return $this->belongsTo(ClientSaleRep::class, "sales_rep", "id");
    }

}
