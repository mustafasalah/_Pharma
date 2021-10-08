<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItems extends Model
{
    use HasFactory;
    public $timestamps=false;

    /** Relations */
    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }

    public function inventoryNotification()
    {
        return $this->hasOne(InventoryNotifications::class,'inventory_item_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class,'supplier_id');
    }

    public function pharmacyBranch()
    {
        return $this->belongsTo(PharmacyBranches::class,'pharmacy_barnch_id');
    }
}
