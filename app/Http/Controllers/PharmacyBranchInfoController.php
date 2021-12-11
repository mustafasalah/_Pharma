<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PharmaciesPhoneNumbers;
use App\Models\PharmacyBranches;
use Illuminate\Support\Facades\DB;

class PharmacyBranchInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pharmacyBranches = PharmacyBranches::all();
         //dd($pharmacyBranches[0]->bankAccount->account_no);
        // $pharmacyBranches = PharmacyBranches::with('bankAccount')->with('atmCard')->get();

        $response=collect();
        foreach($pharmacyBranches as $pharmacyBranch)
        {

            $phone = PharmaciesPhoneNumbers::getPhoneNumbers($pharmacyBranch->id);

            // $phone = PharmaciesPhoneNumbers::where(
            //     'pharmacy_branch_id',$pharmacyBranch->id
            //     )->get(
            //         'phone_number',
            //         'No Phone Number Available'
            //     );

            // $phone = PharmacyBranchInfoController::phoneNumsCutter($phone);
            $data=[
                'id' => $pharmacyBranch->id,
                'name' => $pharmacyBranch->pharmacy->name,
                'branch' => $pharmacyBranch->name,
                'phone_numbers' => $phone,
                "email" => $pharmacyBranch->email,
                "website" => $pharmacyBranch->website,
                'state' => $pharmacyBranch->address->state,
                'city' => $pharmacyBranch->address->city,
                'address' => $pharmacyBranch->address->address,
                "support_delivery" => $pharmacyBranch->support_delivery,
                "delivery_cost" => "not set",
                "created_at" => $pharmacyBranch->created_at,
                "status" => $pharmacyBranch->status,
                "payment_options" =>
                [
                    "mbok" =>
                    [
                        "account_no" => $pharmacyBranch->bankAccount->account_no,
                        "account_owner_name" => $pharmacyBranch->bankAccount->account_owner_name,
                        "bank_branch_name" => $pharmacyBranch->bankAccount->bank_branch_name
                    ],
                    "atm_card" =>
                    [
                        "card_no" => $pharmacyBranch->atmCard->card_no,
                        "card_owner_name" => "not set into atm's table",
                        "bank_name" => $pharmacyBranch->atmCard->bank_name
                    ],

                ]
            ];
            $response->push($data);
        }
        return $response;
    }
/*
        data: {
            id: 1,
            name: "CVS Pharmacy",
            branch: "Omdurman Branch",
            phone_numbers: ["+249965484820", "+249148392930"],
            email: "cvs-pharma@cvs-pharma.com",
            website: "http://www.cvs-pharma.com",
            state: "khartoum",
            city: "omdurman",
            address: "Alwadi Street, near Alrwdah hospital",
            support_delivery: false,
            delivery_cost: 0,
            payment_options: {
                mbok: {
                    account_no: "5678293",
                    account_owner_name: "Mustafa Salah Mustafa",
                    bank_branch_name: "sabren",
                },
                atm_card: {
                    card_no: "",
                    card_owner_name: "",
                    bank_name: "",
                },
            },
        }
*/
    private static function phoneNumsCutter($phone)
    {
        $phoneNums='';
        foreach($phone as $phoneNum){
            if(!$phoneNums==''){
                $phoneNums.='   -   ';
            }
            $phoneNums.=$phoneNum->phone_number;
        }
        return $phoneNums;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        # code...
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moreInfo($type, $id)
    {
        if ($type === "owner") {
            return $this->getOwnerPharmacies($id);
        } else {
            return $this->getEmployeePharmacy($id);
        }
    }

    private function getEmployeePharmacy($id) {
        // employee implemention...
        $pharmacy_branch_id = DB::table('Employees')->where("user_id", $id)->value("pharmacy_branch_id");
        $pharmacyBranch= PharmacyBranches::where("pharmacy_id", $pharmacy_branch_id)->first();

        $response=collect();


            $phone = PharmaciesPhoneNumbers::getPhoneNumbers($pharmacyBranch->id);

            $data=[
                'id' => $pharmacyBranch->id,
                'name' => $pharmacyBranch->pharmacy->name,
                'branch' => $pharmacyBranch->name,
                'phone_numbers' => $phone,
                "email" => $pharmacyBranch->email,
                "website" => $pharmacyBranch->website,
                'state' => $pharmacyBranch->address->state,
                'city' => $pharmacyBranch->address->city,
                'address' => $pharmacyBranch->address->address,
                "lat" => $pharmacyBranch->address->latitude,
                "long" => $pharmacyBranch->address->longitude,
                "created_at" => $pharmacyBranch->created_at,
                "status" => $pharmacyBranch->status,
                "owned_by" => ["id" => $pharmacyBranch->pharmacy->ownedBy->id ,"name" => $pharmacyBranch->pharmacy->ownedBy->fullName()]
            ];
            $response->push($data);

        return $response;
    }

    private function getOwnerPharmacies($id) {
        $pharmacyBranch1=PharmacyBranches::all();

        $pharmacy_id = DB::table('pharmacies')->where("owner", $id)->value("id");

        $pharmacyBranch= PharmacyBranches::where("pharmacy_id", $pharmacy_id)->first();

        $response=collect();

            /*$pharm=User::where(
                'id',$pharmacyBranch->pharmacy->owner
            )->get(
                'first_name'
            )->first();
            $pharm=$pharm->first_name;*/

            $phone = PharmaciesPhoneNumbers::getPhoneNumbers($pharmacyBranch->id);

            $data=[
                'id' => $pharmacyBranch->id,
                'name' => $pharmacyBranch->pharmacy->name,
                'branch' => $pharmacyBranch->name,
                'phone_numbers' => $phone,
                "email" => $pharmacyBranch->email,
                "website" => $pharmacyBranch->website,
                'state' => $pharmacyBranch->address->state,
                'city' => $pharmacyBranch->address->city,
                'address' => $pharmacyBranch->address->address,
                "lat" => $pharmacyBranch->address->latitude,
                "long" => $pharmacyBranch->address->longitude,
                "created_at" => $pharmacyBranch->created_at,
                "status" => $pharmacyBranch->status,
                "owned_by" => ["id" => $pharmacyBranch->pharmacy->ownedBy->id ,"name" => $pharmacyBranch->pharmacy->ownedBy->fullName()]
            ];
            $response->push($data);

        return $response;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
