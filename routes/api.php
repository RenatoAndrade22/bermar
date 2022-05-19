<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\ProductController;
use \App\Http\Controllers\API\EnterpriseProductController;
use \App\Http\Controllers\API\ResellerController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/athenticated', function (Request $request) {
    return $request->user();
});

Route::resources([
    'resellers' => ResellerController::class,
]);

Route::post('/upload/{id}', [\App\Http\Controllers\API\ProductImageController::class, 'store'])->name('upload');
Route::post('/delete-image-product/{id?}', [\App\Http\Controllers\API\ProductImageController::class, 'delete']);

Route::post('/upload-invoice/{id}', [\App\Http\Controllers\API\InvoiceController::class, 'store']);


Route::post('register/user', [\App\Http\Controllers\API\UserController::class, 'store']);
Route::post('register/enterprise', [\App\Http\Controllers\API\EnterpriseController::class, 'store']);
Route::post('register/address', [\App\Http\Controllers\API\AddressController::class, 'store']);

Route::put('update/user/{id}', [\App\Http\Controllers\API\UserController::class, 'update']);

Route::get('products-bermar', [\App\Http\Controllers\API\ProductController::class, 'getProductsBermar']);


Route::post('login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\LoginController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resources([
        'products' => ProductController::class,
        'enterprise-products' => EnterpriseProductController::class,
    ]);
});