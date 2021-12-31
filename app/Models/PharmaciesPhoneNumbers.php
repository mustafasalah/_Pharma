<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PharmaciesPhoneNumbers extends Model
{
    use HasFactory;
    public $timestamps=false;

    /** Relations */

    public function pharmacyBranch()
    {
        return $this->belongsTo(PharmacyBranches::class,'pharmacy_branch_id');
    }

    public static function getPhoneNumbers($id) {
        $phone = DB::table("pharmacies_phone_numbers")->where("pharmacy_branch_id", $id)->pluck("phone_number");
        return array_pad($phone->toArray(), 2, "");
    }
}
