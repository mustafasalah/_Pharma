<?php

namespace App\Http\Controllers;

use App\Models\PharmaciesPhoneNumbers;
use App\Models\PharmacyBranches;
use Illuminate\Http\Request;
/**This class takes the requests from the Pharma Mobile to via route /api/Pharmacies
 * It returns Pharmacies to be viewed
 * created By @OxSama
 */
class PharmacyBranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @author @OxSama
     * @return \Illuminate\Http\Response
     * the response is Json  {
     * 'branch_id' : $id
     * 'name' : $name,
     * 'state' : $state,
     * 'phone' : $phone,
     * 'email' : $email,
     * 'website' : $website,
     * 'lat' => $lat,
     * 'long' : $long
     * }
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
                'state' => $pharmacyBranch->address ? $pharmacyBranch->address->state : '',
                'phone' => $phone,
                "email" => $pharmacyBranch ? $pharmacyBranch->email : '',
                "website" => $pharmacyBranch ?  $pharmacyBranch->website : '',
                "lat" => $pharmacyBranch->address ? $pharmacyBranch->address->latitude : '',
                "long" => $pharmacyBranch->address ? $pharmacyBranch->address->longitude : ''
            ];
            $response->push($data);
        }
        return $response;
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
     * @author @OxSama
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * the response is Json  {
     * 'branch_id' : $id
     * 'name' : $name,
     * 'state' : $state,
     * 'phone' : $phone,
     * 'email' : $email,
     * 'website' : $website,
     * 'lat' => $lat,
     * 'long' : $long
     * }
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
     *  @author @OxSama
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
