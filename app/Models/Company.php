<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $timestamps =false;

    protected $guarded = [];

    /**Relations */

    // Company has many products
    public function products()
    {
        return $this->hasMany(Products::class,'company');
    }

    // Company has many Inventory Items through the products table
    public function inventoryItems(){
        return $this->hasManyThrough(InventoryItems::class,Products::class,'company','product_id');
    }
}
