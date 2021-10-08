<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtmCards extends Model
{
    use HasFactory;
    public $timestamps=false;

    public function pharmacyBranch()
    {
        return $this->belongsTo(PharmacyBranches::class,'id','atm_card');
    }
}
