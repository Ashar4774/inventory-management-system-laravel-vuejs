<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
      'title',
        'category_id',
        'qty',
        'purchase_price',
        'sell_price',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
