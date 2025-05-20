<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
      'name',
      'address',
      'phone_no',
      'description'
    ];

    public function inventories(){
        return $this->hasMany(Inventory::class);
    }

    public function purchase_orders(){
        return $this->hasMany(PurchaseOrder::class);
    }
}
