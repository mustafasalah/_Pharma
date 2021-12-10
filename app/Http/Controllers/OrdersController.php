<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrdersProducts;
use App\Models\Pharmacies;
use App\Models\PharmacyBranches;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrdersController extends Controller
{
    /**
     * Display a listing of all orders except rejected.
     * @author @OxSama
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Orders::where(
            'status',
            '!=',
            'rejected'
            )->get();
        return response(
            $this->buildResponse($orders),
            200,
            [
                'Content-Type' => 'application/json'
            ]);
    }

    /**
     * Display a listing of orders with rejected.
     * @author @OxSama
     * @return \Illuminate\Http\Response
     */
    public function allOrders()
    {
        $orders = Orders::all();
        return response(
            $this->buildResponse($orders),
            201,
            [
                'Content-Type' => 'application/json'
            ]);
    }

    /**
     * Build a collection of objects in the form of
     * {
     *     "orderId": 1223234,
     *     "Date" : "11 November 2021",
     *     "status" : "waiting for review",
     *     "total" : 6700
     * }
     * @author @OxSama
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function buildResponse($orders){

        $response = collect();
        foreach($orders as $key => $order){
            $response[$key] = collect([
                'orderId' => $order->id,
                'Date' => $this->formatDate($order->created_at),
                'status' => $order->status,
                'total' => $this->calculateTotal($order->id)
            ]);
        }
        return $response;

    }

    /**
     * Format the created_at date into d F Y
     * @author @OxSama
     * @param String $date
     * @return String
     */
    private function formatDate($Date){
        return (new Carbon($Date))->format('d F Y');
    }
    /**
     * Calculate the total amount for the order
     * @author @OxSama
     * @param int $orderId
     * @return int $total Amount
     */
    private function calculateTotal($orderId){
        $ordersProductsTable = OrdersProducts::where('order_id','=',$orderId)->get(['price','quantity']);
        $total = 0;
        foreach($ordersProductsTable as $order){
            $total += ($order->price * $order->quantity);
        }
        return $total;
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
     * Display the order details for every order showing the whole products of the order.
     * @author @OxSama
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *     "productname": "Imodium-Instant-Melts",
     *     "pharmacy" : "Castco pharmacies",
     *     "QTY" : 2,
     *     "Unit Price":1200,
     *     "Total Amount" : 2400
     * }
     */
    public function show($id)
    {
        $orderProducts = OrdersProducts::where(
            'order_id',
            '=',
            $id
        )->get();
        $response = collect();
        // return $this->pharmacyBranchName($order[0]->pharmacy_branch_id);
        // return $orderProducts;
        foreach($orderProducts as $key => $orderProduct){
            $order = Orders::where(
                'id',
                '=',
                $id
            )->first();
            $response[$key] = collect([
                "productname"=> Products::where('id','=',$orderProduct->id)->first('name')->name,
                "pharmacy" => $this->pharmacyBranchName($order->pharmacy_branch_id),
                "QTY" => $orderProduct->quantity,
                "Unit Price" => $orderProduct->price,
                "Total Amount" => $orderProduct->price * $orderProduct->quantity
            ]);
        }
        return response(
            $response,
            201,
            [
                'Content-Type' => 'application/json'
            ]
            );
    }
    /**
     * return the whole name of the pharmacy
     * @author @OxSama
     * @param  int  $id
     * @return string
     */
    private function pharmacyBranchName($branchId){
        $pharmacyBranch = PharmacyBranches::where('id','=',$branchId)->first(['name','pharmacy_id']);
        $pharmacy = Pharmacies::where('id','=',$pharmacyBranch->pharmacy_id)->first('name');
        return $pharmacy->name .' - '. $pharmacyBranch->name;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
