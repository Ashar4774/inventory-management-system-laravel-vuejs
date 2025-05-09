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

    public function inventory(){
        return $this->hasMany(Inventory::class);
    }
}
