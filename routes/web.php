<?php

use App\Http\Controllers\CategorySiteController;
use App\Http\Controllers\ProductSiteController;
use App\Http\Controllers\EnterpriseSiteController;
use App\Http\Controllers\RepresentativesSiteController;
use App\Http\Controllers\AssistanceSiteController;
use App\Http\Controllers\ResalesSiteController;
use App\Http\Controllers\ContactSiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [CategorySiteController::class, 'index']);

Route::get('/produtos', [CategorySiteController::class, 'pageCategory']);

Route::get('/categoria/{slug}', [ProductSiteController::class, 'index']);

Route::get('/produto/{slug}', [ProductSiteController::class, 'show']);

Route::get('/empresa', [EnterpriseSiteController::class, 'index']);

Route::get('/representantes', [RepresentativesSiteController::class, 'index']);

Route::get('/assistencia', [AssistanceSiteController::class, 'index']);

Route::get('/revendas', [ResalesSiteController::class, 'index']);

Route::get('/contato', [ContactSiteController::class, 'index']);


Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

