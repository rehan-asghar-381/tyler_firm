<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Models\OrderSupply;
use App\Models\SupplyInventory;

class SupplyInventoryItem extends Model
{
    protected $table    = 'supplies_inventory_items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item',
        'item_slug',
        'created_by_id',
        'created_by_name'
    ];

    public function SupplyInventoryStock(){

        return $this->hasMany(SupplyInventory::class, "item_id", "id");

    }
    
    public function OrderSupplyQty(){

        return $this->hasMany(OrderSupply::class, "item_slug", "item_slug");

    }
}
