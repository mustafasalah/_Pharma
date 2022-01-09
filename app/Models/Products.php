<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $guarded = [];

    /** Relations */

    // In the pivot table the products belongs to many orders
    public function orders()
    {
        return $this->belongsToMany(Orders::class,'orders_products')->withPivot("quantity", "price", "cost");
    }
<<<<<<< HEAD
//modified by saeed
=======

    // Product belongs to one category
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
    public function categories()
    {
        return $this->belongsTo(Categories::class,'id');
    }

    // Product has many inventory items
    public function inventoryItems()
    {
        return $this->hasMany(InventoryItems::class,'product_id');
    }
<<<<<<< HEAD
//modified by saeed
=======

    // Product belongs to one company
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
    public function companies()
    {
        return $this->belongsTo(Company::class,'id');
    }


}
