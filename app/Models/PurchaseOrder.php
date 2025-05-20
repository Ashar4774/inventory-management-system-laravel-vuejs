<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
      'vendor_id',
      'order_number',
      'expected_delivery',
      'status',
      'payment_status',
      'sub_total',
      'discount',
      'discount_type',
      'total_amount',
      'note',
    ];

    public function vendors(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function purchase_order_inventories(){
        return $this->hasMany(PurchaseOrderInventory::class);
    }
}
