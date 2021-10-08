<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryNotifications extends Model
{
    use HasFactory;

    /**Relations */

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItems::class,'inventory_item_id');
    }
}
