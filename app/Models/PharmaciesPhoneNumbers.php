<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PharmaciesPhoneNumbers extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $guarded = [];

    /** Relations */

    public function pharmacyBranch()
    {
        return $this->belongsTo(PharmacyBranches::class, 'pharmacy_branch_id');
    }

    public static function getPhoneNumbers($id)
    {
        $phone = DB::table("pharmacies_phone_numbers")->where("pharmacy_branch_id", $id)->pluck("phone_number");
        return array_pad($phone->toArray(), 2, "");
    }

    public static function setPharmacyPhoneNumbers($id, $phone_numbers)
    {
        $exist_phone_numbers = static::where("pharmacy_branch_id", $id)->get();

        switch ($exist_phone_numbers->count()) {
            case 0:
                static::create(
                    ["phone_number" => $phone_numbers[0], "pharmacy_branch_id" => $id]
                );

                if (!empty($phone_numbers[1])) {
                    static::create(
                        ["phone_number" => $phone_numbers[1], "pharmacy_branch_id" => $id]
                    );
                }
                break;

            case 1:
                static::where(["pharmacy_branch_id" => $id, "phone_number" => $exist_phone_numbers->get(0)->phone_number])->update([
                    "phone_number" => $phone_numbers[0]
                ]);

                if (!empty($phone_numbers[1])) {
                    static::create(
                        ["phone_number" => $phone_numbers[1], "pharmacy_branch_id" => $id]
                    );
                }
                break;

            case 2:
                static::where(["pharmacy_branch_id" => $id, "phone_number" => $exist_phone_numbers->get(0)->phone_number])->update([
                    "phone_number" => $phone_numbers[0]
                ]);

                $query = static::where(["pharmacy_branch_id" => $id, "phone_number" => $exist_phone_numbers->get(1)->phone_number]);

                if (!empty($phone_numbers[1])) {
                    $query->update([
                        "phone_number" => $phone_numbers[1]
                    ]);
                } else {
                    $query->first()->delete();
                }

                break;
        }
    }

    public static function getPhoneNumbers($id) {
        $phone = DB::table("pharmacies_phone_numbers")->where("pharmacy_branch_id", $id)->pluck("phone_number");
        return array_pad($phone->toArray(), 2, "");
    }
}
