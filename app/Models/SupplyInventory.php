<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\SupplyInventoryItem;
class SupplyInventory extends Model
{
    protected $table    = 'supplies_inventory';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item',
        'item_slug',
        'qty',
        'created_by_id',
        'created_by_name'
    ];

    public function InventoryItem(){

        return $this->belongsTo(SupplyInventoryItem::class, "item_id", "id");

    }
    
}
