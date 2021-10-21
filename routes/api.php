<?php

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\PharmacyBranchesController;
use App\Http\Controllers\InventoryItemsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Public route
Route::get('Products/search/{data}', [InventoryItemsController::class,'search']);
Route::resource('Addresses',AddressesController::class);
Route::resource('Products', InventoryItemsController::class);
// Route::get('Products/{Product}/Pharmacy/{Pharmacy}', [InventoryItemsController::class,'show']);
Route::resource('Pharmacies', PharmacyBranchesController::class);


//Private Routes
Route::group(['middleware' => ['auth:sanctum'] ],function () {
    // Route::get('/user', [AddressesController::class,'']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
