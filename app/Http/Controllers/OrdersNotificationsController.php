<?php

namespace App\Http\Controllers;

use App\Models\InventoryNotifications;
use App\Models\OrdersNotifications;
use App\Models\PharmacyNotifications;
use Carbon\Carbon;

class OrdersNotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNotifications($type)
    {
        //
        if ($type === "pharmacies") {
            $pharmacyNotifications = PharmacyNotifications::all();
            // $Orders = Orders::all();
            // $Pharmacy_Notifications = PharmacyNotifications::all();
            // $Inventory_Notifications = InventoryNotifications::all();

            $response = collect();


            foreach ($pharmacyNotifications as $pharmacyNotification) {

                $data = [
                    "id" => $pharmacyNotification->id,
                    "name" => $pharmacyNotification->type,
                    "data" => [
                        "id" => $pharmacyNotification->pharmacyBranch->id,
                        "name" => $pharmacyNotification->pharmacyBranch->pharmacy->name,
                        "owner" => $pharmacyNotification->pharmacyBranch->pharmacy->ownedBy->fullname(),
                    ]
                ];

                if ($pharmacyNotification->type === "new_branch") {
                    $data["data"]["branch"] = $pharmacyNotification->pharmacyBranch->name;
                }

                $response->push($data);
            }
            return $response;
        } else if ($type === "inventory") {
            $inventoryNotifications = InventoryNotifications::all();
            $response = collect();

            foreach ($inventoryNotifications as $inventoryNotification) {

                $data = [
                    "id" => $inventoryNotification->id,
                    "type" => $inventoryNotification->type,
                    "data" => [
                        "id" => $inventoryNotification->inventoryItem->product->id,
                        "name" => $inventoryNotification->inventoryItem->product->name
                    ]
                ];

                if ($data["type"] === "expire_soon") {
                    $data["data"]["duration"] = Carbon::today()->diffInDays($inventoryNotification->inventoryItem->expire_date);
                }

                $response->push($data);
            }
            return $response;
        } else if ($type === "orders") {
            $Orders_Notifications = OrdersNotifications::all();
            $response = collect();

            foreach ($Orders_Notifications as $Order) {

                $data = [
                    "id" => $Order->order_id,
                    "type" => $Order->type,
                    "data" => [
                        "id" => $Order->order->id,
                        "name" => $Order->order->user->fullname()
                    ]
                ];
                $response->push($data);
            }
            return $response;
        } else {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($type, $id)
    {
        $notificationClass = "\\App\\Models\\";

        switch ($type) {
            case "orders":
                $notificationClass .= "OrdersNotifications";
                break;

            case "pharmacy":
                $notificationClass .= "PharmacyNotifications";
                break;

            case "inventory":
                $notificationClass .= "InventoryNotifications";
                break;

            default:
                abort(401, "Bad Request.");
        }

        if ($notificationClass::destroy($id))
            return response(['id' => $id, 200]);
        else
            return response(['id' => $id, 400]);
    }
}
