<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmaciesPhoneNumbers extends Model
{
    use HasFactory;
    public $timestamps=false;

    /** Relations */

    public function pharmacyBranch()
    {
        return $this->belongsTo(PharmacyBranches::class,'pharmacy_branch_id');
    }
}
