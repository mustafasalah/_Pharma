<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyBranches extends Model
{
    use HasFactory;
    public $timestamps=false;

    /**Relations */

    //
    public function pharmacyNotification()
    {
        return $this->hasOne(PharmacyBranches::class,'pharmacy_branch_id');
    }

    public function atmCards()
    {
        return $this->hasMany(AtmCards::class,'id');
    }

    public function bankAccount()
    {
        return $this->hasMany(BankAccounts::class,'id');
    }

    public function employees()
    {
        return $this->hasMany(Employees::class,'pharmacy_branch_id');
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacies::class,'pharmacy_id');
    }

    public function orders()
    {
        return $this->hasMany(Orders::class,'pharmacy_branch_id');
    }

    public function address()
    {
        return $this->hasOne(Addresses::class,'id');
    }

    public function pharmacyPhoneNumbers()
    {
        return $this->hasMany(PharmaciesPhoneNumbers::class,'pharmacy_branch_id');
    }

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItems::class,'pharmacy_branch_id');
    }


}
