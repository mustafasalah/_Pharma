<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacies extends Model
{
    use HasFactory;
    public $timestamps=false;

    /**Relations */

    public function pharmacyBranches()
    {
        return $this->hasMany(PharmacyBranches::class,'pharmacy_id');
    }

    public function ownedBy()
    {
        return $this->belongsTo(User::class,'owner');
    }
}
