<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    public $timestamps=false;

    /** Relations */
    public function orderNotification()
    {
        return $this->hasOne(OrdersNotifications::class,'order_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employees::class,'handled_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }

    public function pharmacyBranch()
    {
        return $this->belongsTo(PharmacyBranches::class,'pharmacy_branch_id','id');
    }

    public function address()
    {
        return $this->hasOne(Addresses::class,'id','address_id');
    }

    public function products()
    {
        return $this->belongsToMany(Products::class,'orders_products','order_id','product_id')->withPivot("cost", "price", "quantity");
    }
}
