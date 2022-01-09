<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\Pharmacies;
use Illuminate\Http\Request;
use App\Models\PharmaciesPhoneNumbers;
use App\Models\PharmacyBranches;
use App\Models\User;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
=======
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355

class PharmaciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pharmacyBranches=PharmacyBranches::all();

        $response=collect();
        foreach($pharmacyBranches as $pharmacyBranch)
<<<<<<< HEAD
        {   
=======
        {
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
            $phone = PharmaciesPhoneNumbers::getPhoneNumbers($pharmacyBranch->id);

            $data=[
                'id' => $pharmacyBranch->id,
                'name' => $pharmacyBranch->pharmacy->name,
<<<<<<< HEAD
                'branch' => $pharmacyBranch->name,               
=======
                'branch' => $pharmacyBranch->name,
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
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
        }
        return $response;
    }
    /*
    {
        id: 1,
        name: "CVS Pharmacy",
        branch: "Omdurman Branch",
        phone_numbers: ["+249965474730", "+249184757530"],
        email: "cvs-pharma@cvs-pharma.com",
        website: "http://www.cvs-pharma.com",
        state: "khartoum",
        city: "omdurman",
        address: "Alwadi Street, near alrowda hospital",
        lat: 12.434034,
        long: 42.439493,
        created_at: "24-09-2021 12:34:03 PM",
        status: "active",
        owned_by: {
            id: 1,
            name: "Mustafa Salah",
<<<<<<< HEAD
        }   
=======
        }
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
    */
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
<<<<<<< HEAD
     * 
=======
     *
>>>>>>> 26f4334637e0d1d2fa2ca67ce1c85cf1c82d1355
     *  api/pharmacies/onwer/:id
     *  api/pharmacies/employee/:id
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
