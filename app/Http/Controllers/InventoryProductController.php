<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Company;
use App\Models\InventoryItems;
use App\Models\Orders;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class InventoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Products=InventoryItems::all();

        $response=collect();
        foreach($Products as $product){
            $category=Categories::where(
                'id',$product->product->category
            )->get(
                'name'
            )->first();
            $category=$category->name;

            $company=Company::where('id', $product->product->company)->get('name')->first();
            $company=$company->name;

            $data=[
                "id" => $product->id,
                "name" => $product->product->name,
                'barcode' => $product->product->barcode,
                "unit" => $product->product->unit,
                "category" => $category,
                "company" =>  $company,
                "photo" => $product->product->photo,
                "cost" => $product->cost,
                "price" => $product->price,
                "supplier" => $product->supplier->name,
                "stock" => $product->stock,
                "reserved" => $product->reserved,
                "arrival_date" => $product->arrival_date,
                "expire_date" => $product->expire_date,
                "online_order" => true // $product->online_order
            ];
            $response->push($data);
        }
        return $response;
    }

   /* {
        id: 1,
        name: "Diarrhoea. Relief - Loperamide Capsules",
        barcode: "1237980133840942",
        unit: "6 Capsules",
        category: "antibiotics",
        company: "Diarrhoea",
        photo: "/assets/images/5.jpg",
        cost: 1000,
        price: 1200,
        supplier: "AbdAlaziz Medical",
        stock: 255,
        reserved: 3,
        arrival_date: "2021-09-12",
        expair_date: "2021-12-12",
        online_order: true,
    },*/

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
