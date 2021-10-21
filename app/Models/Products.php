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
        return $this->belongsToMany(Orders::class,'orders_products','product_id','order_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class,'id');
    }

    public function inventoryItem()
    {
        return $this->hasMany(InventoryItems::class,'product_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'id');
    }


}
