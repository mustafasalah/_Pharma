<?php

namespace App\Http\Controllers;

use App\Models\Suppliers;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Suppliers = Suppliers::all();
 
        $response = collect();
        
         foreach($Suppliers as $Supplier){
 
             $data=[
                 "id" => $Supplier->id,
                 "label" => ucfirst($Supplier->name),
                 "value" => strtolower($Supplier->name)
             ];
             $response->push($data);
         }
         return $response;
    }


}
