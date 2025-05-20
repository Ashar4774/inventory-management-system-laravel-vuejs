<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
      'title',
        'category_id',
        'vendor_id',
        'qty',
        'purchase_price',
        'sell_price',
        'description',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function purchase_order_inventories(){
        return $this->hasMany(PurchaseOrderInventory::class);
    }
}
