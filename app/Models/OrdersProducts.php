<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersProducts extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $guarded = [];

    /** Pivot Table */
    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'id');
    }
}
