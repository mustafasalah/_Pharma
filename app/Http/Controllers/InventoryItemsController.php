<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Company;
use App\Models\InventoryItems;
use App\Models\Orders;
use App\Models\Pharmacies;
use App\Models\PharmacyBranches;
use App\Models\Products;
use App\Models\Suppliers;
use Illuminate\Http\Request;


class InventoryItemsController extends Controller
{

    public function getInventoryItems()
    {
        $inventory_Products = InventoryItems::all();
        $response = collect();
        //$state = request('state');
        foreach ($inventory_Products as $inventory) {
            if ($inventory->online_order === 1) {
                $online_order = true;
            } else $online_order = false;

            $data = [
                "id" => $inventory->id,
                'name' => $inventory->product->name,
                'unit' => $inventory->product->unit,
                'category' => $inventory->product->categories->name,
                'company' => $inventory->product->companies->name,
                'photo' => $inventory->product->photo,
                "cost" => $inventory->cost,
                "price" => $inventory->price,
                "arrival_date" => $inventory->arrival_date,
                "expire_date" => $inventory->expire_date,
                "online_order" => $online_order,
                "stock" => $inventory->stock,
                "reserved" => $inventory->reserved,
                "supplier" => $inventory->supplier->name
            ];
            $response->push($data);
        }
        return $response;
    }
    /*    {
        id: 13,
        name: "ORS Rehydration Salts Lemon",
        barcode: "2783904982340234",
        unit: "12 Tablets",
        category: "antibiotics",
        company: "ORS",
        photo: "/assets/images/2.jpg",
        cost: 300,
        price: 450,
        supplier: "Abo Alra",
        stock: 34,
        reserved: 0,
        arrival_date: "2021-11-12",
        expire_date: "2022-04-12",
        online_order: true,
    }*/
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
        return $this->buildResponse($Products);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $pharmacy_branch_id)
    {
        //undone ///////////////////////////////////////////////////

        $supplier = Suppliers::firstOrCreate(["name" => $request->input("supplier")]);

        $data = [
            "pharmacy_branch_id" => $pharmacy_branch_id,
            'product_id' => $request->input("product_id"),
            "cost" => $request->input('cost'),
            "price" => $request->input('price'),
            "supplier_id" => $supplier->id,
            "stock" => $request->input('stock'),
            "reserved" => $request->input('reserved'),
            "arrival_date" => $request->input('arrival_date'),
            "expire_date" => $request->input('expire_date'),
            "online_order" => $request->boolean("online_order"),
        ];

        if ($inventory = InventoryItems::create($data)) {
            return response([
                "pharmacyBranchId" => (int)$inventory->pharmacy_branch_id,
                'productId' => $inventory->product_id,
                "cost" => $inventory->cost,
                "price" => $inventory->price,
                "arrival_date" => $inventory->arrival_date,
                "expire_date" => $inventory->expire_date,
                "online_order" => $inventory->online_order,
                "stock" => $inventory->stock,
                "reserved" => $inventory->reserved,
                "supplier" => $inventory->supplier->name
            ], 200);
        } else {
            abort(500, "Database Error.");
        }
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
        $supplier = Suppliers::firstOrCreate(["name" => $request->input("supplier")]);

        $data = [
            "id" => $id,
            "cost" => $request->input('cost'),
            "price" => $request->input('price'),
            "supplier_id" => $supplier->id,
            "stock" => $request->input('stock'),
            "reserved" => $request->input('reserved'),
            "arrival_date" => $request->input('arrival_date'),
            "expire_date" => $request->input('expire_date'),
            "online_order" => $request->boolean("online_order")
        ];
        $inventory = InventoryItems::where('id', $id)->first();
        if ($inventory->update($data)) {
            return response([
                "cost" => $inventory->cost,
                "price" => $inventory->price,
                "arrival_date" => $inventory->arrival_date,
                "expire_date" => $inventory->expire_date,
                "online_order" => $inventory->online_order,
                "stock" => $inventory->stock,
                "reserved" => $inventory->reserved,
                "supplier" => $inventory->supplier->name
            ], 200);
        } else {
            abort(500, "Database Error.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { {
            //
            if ($response = InventoryItems::destroy($id))
                return response(['id' => $id, 200]);

            else
                return response(['id' => $id, 400]);
        }
    }

    /**
     * Search the Inventory items by product name and company name and active ingredient
     * @author @OxSama
     *
     */
    public function search($data)
    {
        $companies = Company::where(
            'name',
            'like',
            '%' . $data . '%'
        )->with('inventoryItems')->get();
        // return $companies;

        /** loop to push inventory items from companies */
        $inventoryItemsFromCompanies = collect();
        foreach ($companies as $company) {
            if (!($company->inventoryItems->count() == 0)) {
                foreach ($company->inventoryItems as $singleItem) {
                    unset($singleItem->laravel_through_key); //remove Laravel through key
                    // return $singleItem;
                    $inventoryItemsFromCompanies->push($singleItem);
                }
            }
        }
        // return $inventoryItemsFromCompanies;
        /** end of loop */

        $Products = Products::where(
            'name',
            'like',
            '%' . $data . '%'
        )->orWhere(
            'ingredient',
            'like',
            '%' . $data . '%'
        )->with('inventoryItems')->get();
        // return $Products;

        $inventoryItemsFromProducts = collect();
        foreach ($Products as $product) {
            if (!($product->inventoryItems->count() == 0)) {
                foreach ($product->inventoryItems as $singleItem) {
                    $inventoryItemsFromProducts->push($singleItem);
                }
            }
        }


        $inventoryItems = collect();
        $inventoryItems = $inventoryItems->concat($inventoryItemsFromProducts);
        $inventoryItems = $inventoryItems->concat($inventoryItemsFromCompanies);
        $inventoryItems = $inventoryItems->groupBy('product_id');
        // return $inventoryItems[2]->unique();
        $inventoryItems = InventoryItemsController::uniqueJson($inventoryItems);
        // return $inventoryItems;
        return $this->buildResponse($inventoryItems);
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
        foreach ($keys as $key) {
            $insideKeys = $inventoryItems[$key]->keys();
            foreach ($insideKeys as $insideKey) {
                for ($i = $insideKey + 1; $i < $insideKeys->count(); $i++) {
                    if (isset($inventoryItems[$key][$i])) {
                        if ($inventoryItems[$key][$insideKey]->id == $inventoryItems[$key][$i]->id) {
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
    private function buildResponse($inventoryItems)
    {
        $response = collect();
        foreach ($inventoryItems as $product) {
            $product->first(function ($product) {
                return $product->product;
            });
            // return $product;
            $category = Categories::where(
                'id',
                $product->first()->product->category_id
            )->get(
                'name'
            )->first();
            $category = $category->name;
            $pharmacyBranchesIds = collect();
            $pharmacyBranchesNames = collect();
            $ids = collect();
            $prices = collect();
            foreach ($product as $specificProduct) {
                $pharmacyBranchesIds->push($specificProduct->pharmacy_branch_id);
                $BranchNameAndId = PharmacyBranches::where('id', $specificProduct->pharmacy_branch_id)->get(['name', 'pharmacy_id'])->first();
                $pharmacyName = Pharmacies::where('id', $BranchNameAndId->pharmacy_id)->get('name')->first();
                $pharmacyBranchesNames->push($this->pharmacyBranchName($pharmacyName->name, $BranchNameAndId->name));
                $ids->push($specificProduct->id);
                $prices->push($specificProduct->price);
            }
            //the price right now is the price for the first pharmacy branch
            $data = [
                "ids" => $ids,
                "Product_id" => $product->first()->product->id,
                'Pharmacy_Branches_ids' => $pharmacyBranchesIds,
                'branch_name' => $pharmacyBranchesNames,
                "name" => $product->first()->product->name,
                "category" => $category,
                "prices" => $prices, //the price should change
                "image" => $product->first()->product->photo,
                "des" => $product->first()->product->unit,
                "prescription" => $this->prescription($product->first()->product->need_prescription),
                "ingredient" => $product->first()->product->ingredient,
                "description" => $product->first()->product->description,
                "usage_instructions" => $product->first()->product->usage_instructions,
                "warnings" => $product->first()->product->warnings,
                "side_effects" => $product->first()->product->side_effects,
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


    public function pharmacyBranchName($pharmacyName, $BranchName)
    {
        return ($BranchName == '' || $BranchName == 'main branch') ?  $pharmacyName
            : $pharmacyName . ' - ' . $BranchName;
    }

    /**
     * Prescription status
     * @author @OxSama
     * @param tinyint $prescription
     * @return boolean
     *
     */
    private function prescription($prescription)
    {
        return $prescription == 0 ? false : true;
    }

    public function all($pharmacy_branch_id = null)
    {

        if (isset($pharmacy_branch_id)) {
            $Products = InventoryItems::where("pharmacy_branch_id", $pharmacy_branch_id)->get();
        } else {
            $Products = InventoryItems::all();
        }

        $response = collect();
        foreach ($Products as $product) {
            $category = Categories::where(
                'id',
                $product->product->category_id
            )->get(
                'name'
            )->first();
            $category = $category->name;

            $company = Company::where('id', $product->product->company_id)->get('name')->first();
            $company = $company->name;

            $data = [
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

    public function namesList()
    {
        $inventoryItems = InventoryItems::with(
            'product'
        )->get();
        $products = $inventoryItems->pluck('product');
        return response(
            $products->pluck('name'),
            201,
            [
                'content-type' => 'application/json'
            ]
        );
    }
}
