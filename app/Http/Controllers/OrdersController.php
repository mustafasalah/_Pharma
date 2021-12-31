<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrdersProducts;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Orders=Orders::all();

        $response=collect();
        foreach($Orders as $order){

            $products=OrdersProducts::get(
                'price'
            )->first();
            $products=$products->price;

           /* $company=Company::where('id',$product->product->company)->get('name')->first();
            $company=$company->name;

            $order=Orders::get('type')->first();
            $order=$order->type;*/
            $data=[
                "id" => $order->id,
                "type" => $order->type,
                "price" => $products,
                "status" => $order->status,
                "handled_by" => 
                     [
                        "id" => $order->employee->id,
                        "name" => $order->employee->fullname
                     ],
                "date" =>  $order->created_at,
                "payment" => 
                     [
                         "method" => $order->payment_method ,
                         "proof" => $order->payment_proof_screenshot
                     ],
                "products" => 
                $order->products->map(function($product) {
                    return [
                        "name" => $product->name,
                        "qty" => $product->pivot->quantity,
                        "price" => $product->pivot->price
                    ];
                }),
                "products_amount" => $order->products_amount,
                "discount" => $order->discount,
                "vat" => $order->vat,
                "delivery" => $order->delivery
            ];
            $response->push($data);
        }
        return $response;
    }
    /*{
        id: 23820,
        type: "local",
        price: 5400,
        status: "finished",
        handled_by: {
            id: 1,
            name: "Mustafa Salah",
        },
        date: "24-09-2021 12:34:03 PM",
        payment: {
            method: "cash",
            proof: "/assets/images/pay.jpg",
        },
        products: [
            {
                name: "Diarrhoea. Relief - Loperamide Capsules",
                qty: 1,
                price: 1200,
            },
            {
                name: "Ovex Family Pack Tablets",
                qty: 2,
                price: 1400,
            },
        ],
        products_amount: 5400,
        discount: 0,
        vat: 0,
        delivery: 0,
    }*/
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
