<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $Drugs=Products::all();



        $response=collect();
        foreach($Drugs as $drug){

            $data=[
                "id" => $drug->id,
                "name" => $drug->name,
                'barcode' => $drug->barcode,
                "unit" => $drug->unit,
                "category" => $drug->categories->name,
                "company" =>  $drug->companies->name,
                "photo" => ["url" => $drug->photo, "size" => 22222],
                "ingredient" => $drug->ingredient,
                "need_perspection" => $drug->need_perspection,
                "description" => $drug->description,
                "usage" => $drug->usage,
                "warnings" => $drug->warnings,
                "side_effects" => $drug->side_effects
            ];
            $response->push($data);
        }
        return $response;
    }
    /*
        id: 1,
        name: "Diarrhoea. Relief - Loperamide Capsules",
        barcode: "1237980133840942",
        unit: "6 Capsules",
        category: "antibiotics",
        company: "Diarrhoea",
        photo: { url: "/assets/images/5.jpg", size: 123000 },
        ingredient: "loperamide hydrochloride",
        need_perspection: false,
        description: "",
        usage: "",
        warnings: "",
        side_effects: "",
    }
     */
    public function uploadPhoto(Request $request){

        $request->validate([ 
            'product_id' => 'required',
            'product_photo' => 'required|mimes:png,jpeg,jpg,gif,svg|max:2048',
        ]);

        $product_photo = $request->file("product_photo");

        if ($product_photo->isValid()) {
             
            //store file into images folder
            $file_name = $request->product_id . "." . $product_photo->extension();
            $url = "images/" . $file_name;
            
            $product_photo->storeAs('/public/images', $file_name);
            $drug = Products::find($request->product_id);
            $drug->photo = Storage::url($url); // + /storage/ + $url
            $drug->save();
            
            return response()->json([
                "url" => $drug->photo,
                "size" => Storage::size("public/images/" . $file_name),
            ]);
        }
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
