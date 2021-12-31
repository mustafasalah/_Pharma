<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItems extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $guarded = [];

    /** Relations */

    // Inventory Item belongs to one product
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    // Inventory Item has one notification
    public function inventoryNotification()
    {
        return $this->hasOne(InventoryNotifications::class, 'inventory_item_id');
    }

    // Inventory Item belongs to one supplier
    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }

    // Inventory Item belongs to one branch
    public function pharmacyBranch()
    {
        return $this->belongsTo(PharmacyBranches::class, 'pharmacy_branch_id');
    }
}
