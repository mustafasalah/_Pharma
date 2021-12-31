<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    public $timestamps=false;

    /** Relations */

    public function orders()
    {
        return $this->belongsToMany(Orders::class,'orders_products')->withPivot("quantity", "price", "cost");
    }
//modified by saeed
    public function categories()
    {
        return $this->belongsTo(Categories::class,'id');
    }

    public function inventoryItem()
    {
        return $this->hasMany(InventoryItems::class,'product_id');
    }
//modified by saeed
    public function companies()
    {
        return $this->belongsTo(Company::class,'id');
    }


}
