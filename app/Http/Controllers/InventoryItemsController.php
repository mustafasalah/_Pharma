<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Company;
use App\Models\InventoryItems;
use App\Models\Products;
use Illuminate\Http\Request;

class InventoryItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Products=InventoryItems::all();
        return InventoryItemsController::buildResponse($Products);
    }
    /**
     * @param Illuminate\Database\Eloquent\Collection $Products
     * A Method that accepts a collection of inventory items and build a response with
     * specific schema
     * @return {
     * "id": int,
     * "Pharmacy_id": int,
     * "name": String,
     * "category": String,
     * "price": int,
     * "image": String,
     * "des": String
     * }
     */
    private static function buildResponse($Products){
        $Products->every(
            function($product){
                return $product->product;
            }
        );
        $response=collect();
        foreach($Products as $product){
            $category=Categories::where(
                'id',$product->product->category
            )->get(
                'name'
            )->first();
            $category=$category->name;
            $data=[
                "id" => $product->id,
                'Pharmacy_id' => $product->pharmacy_branch_id,
                "name" => $product->product->name,
                "category" => $category,
                "price" => $product->price,
                "image" => $product->product->photo,
                "des" => $product->product->description
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Products=InventoryItems::where(
            'id',$id
        )->get();
        $Products->every(
            function($product){
                return $product->product;
            }
        );
        $response=collect();
        foreach($Products as $product){
            $category=Categories::where(
                'id',$product->product->category
            )->get(
                'name'
            )->first();
            $category=$category->name;
            $data=[
                "id" => $product->id,
                'Pharmacy_id' => $product->pharmacy_branch_id,
                "name" => $product->product->name,
                "category" => $category,
                "price" => $product->price,
                "image" => $product->product->photo,
                "des" => $product->product->description
            ];
            $response->push($data);
        }
        return $response->first();
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
        return InventoryItems::destroy($id);
    }

    public function search($data)
    {
        $Products=Products::where(
            'name', 'like', '%'.$data.'%'
        )->orWhere(
            'ingredient', 'like', '%'.$data.'%'
        )->get();
        $Products->every(
            function($product){
                return $product->inventoryItem;
            }
        );
        $companies=Company::where(
            'name','like','%'.$data.'%'
        )->get();
        $companies->every(
            function($company){
                return $company->products;
            }
        );
        $inventoryItems=collect();
        for ($i=0; $i < $Products->count() ; $i++){
            $inventoryitem=$Products[$i]->inventoryItem;
            if ($inventoryitem->count()>=0) {
                for ($y=0; $y < $inventoryitem->count(); $y++) {
                    $inventoryItems->push($inventoryitem[$y]);
                }
            }
        }
        foreach($companies as $company){
            for($i=0; $i < $company->products->count(); $i++){
                $Products=$company->products;
                for ($i=0; $i < $Products->count() ; $i++){
                    $inventoryitem=$Products[$i]->inventoryItem;
                    if ($inventoryitem->count()>=0) {
                        for ($y=0; $y < $inventoryitem->count(); $y++) {
                            $inventoryItems->push($inventoryitem[$y]);
                        }
                    }
                }
            }
        }
        $inventoryItems->unique();
        return InventoryItemsController::buildResponse($inventoryItems);
    }
}
