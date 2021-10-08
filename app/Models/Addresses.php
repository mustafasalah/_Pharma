<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;
    public $timestamps=false;

    public function user(){
        return $this->belongsTo(User::class,'id','address_id');
    }

    public function order(){
        return $this->belongsTo(Orders::class,'id','address_id');
    }

    public function pharmacyBranch(){
        return $this->belongsTo(PharmacyBranches::class,'id','address_id');
    }
}
