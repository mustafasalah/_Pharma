<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    public $timestamps=false;

    /** Relations */

    // In the pivot table the products belongs to many orders
    public function orders()
    {
        return $this->belongsToMany(Orders::class,'orders_products')->withPivot("quantity", "price", "cost");
    }

    // Product belongs to one category
    public function categories()
    {
        return $this->belongsTo(Categories::class,'id');
    }

    // Product has many inventory items
    public function inventoryItems()
    {
        return $this->hasMany(InventoryItems::class,'product_id');
    }

    // Product belongs to one company
    public function companies()
    {
        return $this->belongsTo(Company::class,'id');
    }


}
