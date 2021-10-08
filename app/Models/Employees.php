<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;
    public $timestamps=false;

    /** Relations */

    public function orders()
    {
        return $this->hasMany(Orders::class,'handeled_by');
    }

    public function pharmacyBranch()
    {
        return $this->belongsTo(PharmacyBranches::class,'pharmacy_branch_id');
    }
}
