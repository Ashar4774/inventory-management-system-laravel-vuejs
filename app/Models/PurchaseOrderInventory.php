<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderInventory extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'inventory_id',
        'unit_price',
        'quantity_ordered',
        'quantity_received',
        'discount',
        'discount_type',
        'total_price',
        'status',
    ];

    public function purchase_orders(){
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function inventories(){
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
