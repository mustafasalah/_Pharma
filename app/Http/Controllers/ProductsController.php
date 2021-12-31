<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

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
                "photo" => $drug->photo,
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
