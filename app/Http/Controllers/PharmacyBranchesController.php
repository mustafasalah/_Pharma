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
        $pharmacyBranches=PharmacyBranches::where(
            'status','=','active'
            )->with(
                'pharmacy'
                )->with(
                    'pharmacyPhoneNumbers'
                    )->with(
                        'address'
                        )->with(
                            'bankAccount'
                            )->with(
                                'atmCard'
                            )->get();
        // return $pharmacyBranches;
        $response=collect();

        foreach($pharmacyBranches as $pharmacyBranch)
        {
            $name = (new InventoryItemsController)->pharmacyBranchName($pharmacyBranch->pharmacy->name,$pharmacyBranch->name);
            $phone = PharmaciesPhoneNumbers::where(
                'pharmacy_branch_id',$pharmacyBranch->id
                )->get(
                    'phone_number',
                    'No Phone Number Available'
                );
            $data=[
                'branch_id' => $pharmacyBranch->id,
                'name' => $name,
                'state' => $pharmacyBranch->address ? $this->fullAddress($pharmacyBranch->address) : '',
                'phone' => $this->phoneNumsCutter($phone),
                "email" => $pharmacyBranch ? $pharmacyBranch->email : '',
                "website" => $pharmacyBranch ?  $pharmacyBranch->website : '',
                "lat" => $pharmacyBranch->address ? $pharmacyBranch->address->latitude : '',
                "long" => $pharmacyBranch->address ? $pharmacyBranch->address->longitude : '',
                "delivery" => $this->deliveryStatus($pharmacyBranch->support_delivery),
                "payment_details"=> [
                    "MBOKAccountNo"=> $pharmacyBranch->bankAccount->account_no,
                    "MBOKAccountOwner"=> $pharmacyBranch->bankAccount->account_owner_name,
                    "MBOKBranchBank"=> $pharmacyBranch->bankAccount->bank_branch_name,
                    "ATMCardNo"=> $pharmacyBranch->atmCard->card_no,
                    "ATMBankName"=> $pharmacyBranch->atmCard->bank_name
                    ]
            ];
            $response->push($data);
        }
        return response($response,
        200,
        [
            'content-type' => 'application/json'
            ]
    );
    }

    /**
     * Create the address string
     * @author @OxSama
     * @param  object $addressObj
     * @return string
     * the param $addressObj is Json  {
     * "id": 2,
     * "state": "Bessie VonRueden",
     * "city": "Reynoldschester",
     * "address": "145 Emmanuel Street\nKayaside, IN 19252",
     * "latitude": 58.224405,
     * "longitude": -166.129946
     * }
     */
    private function fullAddress($addressObj){
        return $addressObj->state . ',' . $addressObj->city . ',' . $addressObj->address;
    }

    /**
     * Create the address string
     * @author @OxSama
     * @param  int $delivery
     * @return boolean
     */
    private function deliveryStatus($delivery){
        return $delivery==0 ? false:true;
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
        $pharmacyBranch=PharmacyBranches::where(
            'status', '=', 'active'
        )->with(
            'pharmacy'
        )->with(
            'pharmacyPhoneNumbers'
        )->with(
            'address'
        )->with(
            'bankAccount'
        )->with(
            'atmCard'
        )->find($id);
        $name = $pharmacyBranch->pharmacy->name.' - '.$pharmacyBranch->name;
        $phone = PharmaciesPhoneNumbers::where(
            'pharmacy_branch_id',$pharmacyBranch->id
            )->get(
                'phone_number',
                'No Phone Number Available'
            );
        return response([
            'branch_id' => $pharmacyBranch->id,
            'name' => $name,
            'state' => $pharmacyBranch->address ? $this->fullAddress($pharmacyBranch->address) : '',
            'phone' => $this->phoneNumsCutter($phone),
            "email" => $pharmacyBranch ? $pharmacyBranch->email : '',
            "website" => $pharmacyBranch ?  $pharmacyBranch->website : '',
            "lat" => $pharmacyBranch->address ? $pharmacyBranch->address->latitude : '',
            "long" => $pharmacyBranch->address ? $pharmacyBranch->address->longitude : '',
            "delivery" => $this->deliveryStatus($pharmacyBranch->support_delivery),
            "payment_details"=> [
                "MBOKAccountNo"=> $pharmacyBranch->bankAccount->account_no,
                "MBOKAccountOwner"=> $pharmacyBranch->bankAccount->account_owner_name,
                "MBOKBranchBank"=> $pharmacyBranch->bankAccount->bank_branch_name,
                "ATMCardNo"=> $pharmacyBranch->atmCard->card_no,
                "ATMBankName"=> $pharmacyBranch->atmCard->bank_name
                ]
        ],
        200,
        [
            'content-type' => 'application/json'
            ]
    );
    }

    /**
     * Format the phone numbers
     *
     * @param $phone array[] of phone numbers
     *
     * @return string phone numbers "+249##########    -   +249##########  -....."
     *
     * @author @OxSama
     */
    private function phoneNumsCutter($phone)
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
