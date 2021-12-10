<?php

namespace App\Http\Controllers;
use App\Models\OrdersNotifications;
use App\Models\PharmacyNotifications;
use App\Models\InventoryNotifications;
use App\Models\Orders;
use App\Models\Employees;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;
use SebastianBergmann\LinesOfCode\Counter;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Orders_Notifications = OrdersNotifications::all();
        $Orders = Orders::all();
        $Pharmacy_Notifications = PharmacyNotifications::all();
        $Inventory_Notifications = InventoryNotifications::all();

        $response = collect();
        
        
         /*   foreach($Pharmacy_Notifications as $pharmacy){

                $data=[
                    "id" => $pharmacy->id,
                    "name" => $pharmacy->type,
                    "content" => $pharmacy->type . " Joining the pharma platform"
                ];
                $response->push($data);
            }
            return $response; */
        

        
        $count = 1;
            foreach($Orders_Notifications as $Order){
                /*$orderNotif1=OrdersNotifications::where('order_id',/*$Order->orderNotification->id)->get('order_id');
                $orderNotif2=OrdersNotifications::where('id',/*$Order->orderNotification->type)->get('type');*/
                /*$order = $Order->order->handled_by;*/
                $data=[
                    "id" => $Order->order_id,
                    "type" => $Order->type,
                    "content" => $Order->type . " #" . $count++/*Count(array($Order->id+1))*/ . " From"  
                    /* $Orders->employee->fullname*/
                    
                ];
                $response->push($data);
            }
            return $response;
        
        
    }

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
     */
    public function show($id)
    {
        //
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
