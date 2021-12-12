<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Company;
use App\Models\InventoryItems;
use App\Models\Pharmacies;
use App\Models\PharmacyBranches;
use App\Models\Products;
use Illuminate\Http\Request;


class InventoryItemsController extends Controller
{
    /**
     * @author @OxSama
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Products = InventoryItems::all()->groupBy('product_id');
        // return $Products[2];
        return InventoryItemsController::buildResponse($Products);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //undone
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

    /**
     * Search the Inventory items by product name and company name and active ingredient
     * @author @OxSama
     *
     */
    public function search($data)
    {
        $companies=Company::where(
            'name','like','%'.$data.'%'
        )->with('inventoryItems')->get();
        // return $companies;

        /** loop to push inventory items from companies */
        $inventoryItemsFromCompanies=collect();
        foreach($companies as $company){
            if(!($company->inventoryItems->count() == 0)){
                foreach($company->inventoryItems as $singleItem){
                    unset($singleItem->laravel_through_key);//remove Laravel through key
                    // return $singleItem;
                    $inventoryItemsFromCompanies->push($singleItem);
                }
            }
        }
        // return $inventoryItemsFromCompanies;
        /** end of loop */

        $Products=Products::where(
            'name', 'like', '%'.$data.'%'
        )->orWhere(
            'ingredient', 'like', '%'.$data.'%'
        )->with('inventoryItems')->get();
        // return $Products;

        $inventoryItemsFromProducts=collect();
        foreach( $Products as $product ) {
            if( !($product->inventoryItems->count() == 0 ) ){
                foreach( $product->inventoryItems as $singleItem ){
                    $inventoryItemsFromProducts->push($singleItem);
                }
            }
        }


        $inventoryItems=collect();
        $inventoryItems=$inventoryItems->concat($inventoryItemsFromProducts);
        $inventoryItems = $inventoryItems->concat($inventoryItemsFromCompanies);
        $inventoryItems = $inventoryItems->groupBy('product_id');
        // return $inventoryItems[2]->unique();
        $inventoryItems = InventoryItemsController::uniqueJson($inventoryItems);
        // return $inventoryItems;
        return InventoryItemsController::buildResponse($inventoryItems);
    }


    /**
     * @author @OxSama
     * @param Illuminate\Database\Eloquent\Collection $inventoryItems
     * A Method that accepts a collection of inventory items grouped by its product ids and remove duplicated objects
     * @return Illuminate\Database\Eloquent\Collection $inventoryItems
     */
    public static function uniqueJson($inventoryItems)
    {
        $keys = $inventoryItems->keys();
        foreach ($keys as $key){
            $insideKeys = $inventoryItems[$key]->keys();
            foreach($insideKeys as $insideKey){
                for($i=$insideKey+1; $i < $insideKeys->count(); $i++) {
                    if(isset($inventoryItems[$key][$i])){
                        if($inventoryItems[$key][$insideKey]->id == $inventoryItems[$key][$i]->id){
                            unset($inventoryItems[$key][$i]);
                        }
                    }
                }
            }
        }
        return $inventoryItems;
    }


    /**
     * @author @OxSama
     * @param Illuminate\Database\Eloquent\Collection $Products
     * A Method that accepts a collection of inventory items grouped by its product ids and build a response with
     * specific schema
     * @return {
     * "ids": collection int,
     * "Product_id" : int,
     * "Pharmacy_Branches_ids": collection int,
     * "name": String,
     * "category": String,
     * "prices": int,
     * "image": String,
     * "des": String
     * }
     */
    private static function buildResponse($Products){
        $response=collect();
        foreach($Products as $product){
            $product->first(function($product){
                return $product->product;
            });
            // return $product;
            $category=Categories::where(
                    'id' , $product->first()->product->category
                    )->get(
                        'name'
                    )->first();
            $category=$category->name;

            $pharmacyBranchesIds = collect();
            $pharmacyBranchesNames = collect();
            $ids = collect();
            $prices = collect();
            foreach($product as $specificProduct){
                $pharmacyBranchesIds->push($specificProduct->pharmacy_branch_id);
                $BranchNameAndId = PharmacyBranches::where('id', $specificProduct->pharmacy_branch_id)->get(['name','pharmacy_id'])->first();
                $pharmacyName = Pharmacies::where('id',$BranchNameAndId->pharmacy_id)->get('name')->first();
                $pharmacyBranchesNames->push($branchName = $pharmacyName->name . '  -   ' .$BranchNameAndId->name);
                $ids->push($specificProduct->id);
                $prices->push($specificProduct->price);
            }
            //the price right now is the price for the first pharmacy branch
            $data=[
                "ids" => $ids,
                "Product_id" => $product->first()->product->id,
                'Pharmacy_Branches_ids' => $pharmacyBranchesIds,
                'branch_name' => $pharmacyBranchesNames,
                "name" => $product->first()->product->name,
                "category" => $category,
                "prices" => $prices,//the price should change
                "image" => $product->first()->product->photo,
                "des" => $product->first()->product->description
            ];
            $response->push($data);
            // return $response;
        }
        return response(
            $response,
            201,
            [
                'content-type' => 'application/json'
            ]
        );
    }

    public function all()
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
}
