<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersNotifications extends Model
{
    use HasFactory;

    /**Relations */

    public function order()
    {
        return $this->belongsTo(Orders::class,'order_id');
    }
}
