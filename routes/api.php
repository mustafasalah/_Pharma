<?php

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\PharmacyBranchesController;
use App\Http\Controllers\InventoryItemsController;
use App\Http\Controllers\InventoryProductController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PharmaciesController;
use App\Http\Controllers\PharmacyBranchInfoController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\UsersController;
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
Route::resource('PharmaciesBranches', PharmacyBranchesController::class);//modified from */Pharmacies*

/** Register and login routes */
Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
/** end of Reg and Log */


//Private Routes
Route::group(['middleware' => ['auth:sanctum'] ],function () {
    /** Logout route */
    Route::post('/logout', [AuthController::class,'logout']);

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });





//Public route *2*......
Route::resource('users', UsersController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('companies', CompanyController::class);
Route::resource('employees', EmployeesController::class);
Route::resource('inventory', InventoryProductController::class);
Route::resource('notifications', NotificationsController::class);
Route::resource('suppliers', SuppliersController::class);
Route::resource('orders', OrdersController::class);
Route::resource('drugs', ProductsController::class);
Route::get("pharmacies/{type}/{id}", [PharmacyBranchesController::class, "show"]);
Route::resource('pharmacies', PharmaciesController::class);
Route::resource('pharmacyBranchInfo', PharmacyBranchInfoController::class);