<?php

namespace App\Http\Controllers;

use App\Models\PharmaciesPhoneNumbers;
use App\Models\PharmacyBranches;
use Illuminate\Http\Request;

class PharmacyBranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pharmacyBranches=PharmacyBranches::all();
        $pharmacyBranches->every(
            function($pharmacyBranch){
                return $pharmacyBranch->pharmacy;
            }
        );
        $pharmacyBranches->every(
            function($pharmacyBranch){
                return $pharmacyBranch->pharmacyPhoneNumbers;
            }
        );
        $pharmacyBranches->every(
            function($pharmacyBranch){
                return $pharmacyBranch->address;
            }
        );
        $response=collect();
        foreach($pharmacyBranches as $pharmacyBranch)
        {
            $name = $pharmacyBranch->pharmacy->name.' - '.$pharmacyBranch->name;
            $phone = PharmaciesPhoneNumbers::where(
                'pharmacy_branch_id',$pharmacyBranch->id
                )->get(
                    'phone_number',
                    'No Phone Number Available'
                );
            $phone = PharmacyBranchesController::phoneNumsCutter($phone);
            $data=[
                'branch_id' => $pharmacyBranch->id,
                'name' => $name,
                'state' => $pharmacyBranch->address->state,
                'phone' => $phone,
                "email" => $pharmacyBranch->email,
                "website" => $pharmacyBranch->website,
                "lat" => $pharmacyBranch->address->latitude,
                "long" => $pharmacyBranch->address->longitude
            ];
            $response->push($data);
        }
        return $response;
        /**return response()->json([
            'name' => $name,
            'state' => $state,
            'phone' => $phone,
            "email" => $email,
            "website" => $website,
            "lat" => $lat,
            "long" => $long
        ]); */
        // {
        //     "name":"CVS Pharmacy",
        //     "state":"khartoum State,Khartoum,Khartoum 2",
        //     "phone":"+249912000023 - +249112000023",
        //     "email":"cvspharmacysupport@cvs-pharma.com",
        //     "website":"www.cvs-Pharma.com",
        //     "lat":15.569893951439786,
        //     "long":32.53183948952209
        // }
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
    public function show($id)
    {
        $pharmacyBranches=collect();
        $pharmacyBranches->push(PharmacyBranches::find($id));
        $pharmacyBranches->every(
            function($pharmacyBranch){
                return $pharmacyBranch->pharmacy;
            }
        );
        $pharmacyBranches->every(
            function($pharmacyBranch){
                return $pharmacyBranch->pharmacyPhoneNumbers;
            }
        );
        $pharmacyBranches->every(
            function($pharmacyBranch){
                return $pharmacyBranch->address;
            }
        );
        $response=collect();
        foreach($pharmacyBranches as $pharmacyBranch)
        {
            $name = $pharmacyBranch->pharmacy->name.' - '.$pharmacyBranch->name;
            $phone = PharmaciesPhoneNumbers::where(
                'pharmacy_branch_id',$pharmacyBranch->id
                )->get(
                    'phone_number',
                    'No Phone Number Available'
                );
            $phone = PharmacyBranchesController::phoneNumsCutter($phone);
            $data=[
                'branch_id' => $pharmacyBranch->id,
                'name' => $name,
                'state' => $pharmacyBranch->address->state,
                'phone' => $phone,
                "email" => $pharmacyBranch->email,
                "website" => $pharmacyBranch->website,
                "lat" => $pharmacyBranch->address->latitude,
                "long" => $pharmacyBranch->address->longitude
            ];
            $response->push($data);
        }
        return $response->first();
    }
    /** Format the phone numbers
     *
     *  @param  $phone array[] of phone numbers
     *  @return string phone numbers "+249##########    -   +249##########  -....."
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
