<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;
    public $timestamps=false;

    /** Relations */

    public function inventoryItems()
    {
        return $this->hasMany(inventoryItems::class,'supplier_id');
    }
}
