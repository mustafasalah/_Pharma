<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyNotifications extends Model
{
    use HasFactory;

    /** Relations */

    public function pharmacyBranch()
    {
        return $this->belongsTo(PharmacyBranches::class,'pharmacy_branch_id');
    }
}
