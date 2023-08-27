<?php

use App\Http\Controllers\API\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\ProductController;
use \App\Http\Controllers\API\EnterpriseProductController;
use \App\Http\Controllers\API\ResellerController;
use \App\Http\Controllers\API\EnterpriseController;
use \App\Http\Controllers\API\AddressController;
use \App\Http\Controllers\API\UserController;
use \App\Http\Controllers\API\ProductImageController;
use \App\Http\Controllers\API\InvoiceController;
use \App\Http\Controllers\API\SaleOrderController;
use \App\Http\Controllers\API\WarrantyController;
use \App\Http\Controllers\API\ChatController;
use \App\Http\Controllers\API\ChatMessageController;
use \App\Http\Controllers\API\WarrantyProductController;
use \App\Http\Controllers\API\BudgetController;
use \App\Http\Controllers\API\PriceTableController;
use \App\Http\Controllers\API\IntegrationProductController;
use \App\Http\Controllers\API\LinkController;
use \App\Http\Controllers\API\PaymentMethodController;
use \App\Http\Controllers\API\CatalogController;
use \App\Http\Controllers\API\PaymentTermsController;
use \App\Http\Controllers\API\ExternalApiController;
use \App\Http\Controllers\API\CarrierController;
use \App\Http\Controllers\API\PriceController;
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

Route::post('/upload/{id}', [ProductImageController::class, 'store']);
Route::post('/upload-manual/{id}', [ProductController::class, 'uploadManual']);
Route::post('/delete-image-product/{id?}', [ProductImageController::class, 'destroy']);

Route::post('/upload-invoice/{id}', [\App\Http\Controllers\API\InvoiceController::class, 'store']);

Route::post('/upload-boleto/{id}', [\App\Http\Controllers\API\BoletoController::class, 'store']);
Route::delete('/boleto-delete/{id}', [\App\Http\Controllers\API\BoletoController::class, 'destroy']);

Route::get('/download-invoice/{id}', [\App\Http\Controllers\API\InvoiceController::class, 'downloadInvoice']);

Route::post('register/user', [\App\Http\Controllers\API\UserController::class, 'store']);
Route::post('register/enterprise', [\App\Http\Controllers\API\EnterpriseController::class, 'store']);
Route::post('register/address', [\App\Http\Controllers\API\AddressController::class, 'store']);

Route::put('update/user/{id}', [\App\Http\Controllers\API\UserController::class, 'update']);

Route::get('products-bermar', [\App\Http\Controllers\API\ProductController::class, 'getProductsBermar']);

Route::get('buyers', [\App\Http\Controllers\API\UserController::class, 'getBuyers']);
Route::get('get-companies-state/{type}/{uf}', [\App\Http\Controllers\API\getEnterprisesController::class, 'getRepresentatives']);

Route::post('login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\LoginController::class, 'logout']);

Route::post('validate-tables', [PriceController::class, 'validateTables']);


// PAINEL
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resources([
        'category' => CategoryController::class,
        'product' => ProductController::class,
        'enterprise-products' => EnterpriseProductController::class,
        'enterprise' => EnterpriseController::class,
        'address' => AddressController::class,
        'user' => UserController::class,
        'product-image' => ProductImageController::class,
        'warranty' => WarrantyController::class,
        'chat' => ChatController::class,
        'chat-message' => ChatMessageController::class,
        'sale-order' => SaleOrderController::class,
        'warranty-product' => WarrantyProductController::class,
        'budget' => BudgetController::class,
        'price_table' => PriceTableController::class,
        'links' => LinkController::class,
        'catalog' => CatalogController::class,
        'payment-methods' => PaymentMethodController::class,
        'sale' => SaleOrderController::class,
        'payment-terms' => PaymentTermsController::class,
        'carriers' => CarrierController::class,
        'integration_product' => IntegrationProductController::class
    ]);
    
    Route::get('my-shopping', [SaleOrderController::class, 'myShopping']);

    Route::post('update-catalog/{id}', [CatalogController::class, 'updateCatalog']);

    Route::get('enterprises-type/{type}', [EnterpriseController::class, 'getEnterpriseType']);
    Route::get('companies-assistance', [EnterpriseController::class, 'enterpriseAssistance']);
    Route::get('sale-orders-by-user', [SaleOrderController::class, 'getSaleOrderByUser']);
    Route::post('upload-file-chat/{id}', [ChatMessageController::class, 'uploadFile']);
    
    Route::get('total-sales', [SaleOrderController::class, 'getTotalSales']);

    Route::get('all-sale-orders', [SaleOrderController::class, 'allSales']);

    Route::get('products-api-external', [ExternalApiController::class, 'allProducts']);
    Route::get('table-price-api-external', [ExternalApiController::class, 'allTablePrice']);
    Route::get('clients-api-external', [ExternalApiController::class, 'allClients']);
    Route::get('payment-method-api-external', [ExternalApiController::class, 'allPaymentMethod']);
    Route::get('payment-terms-api-external', [ExternalApiController::class, 'allPaymentTerms']);
    Route::get('carriers-api-external', [ExternalApiController::class, 'allCarriers']);
    
    
    Route::post('prices-by-table', [PriceController::class, 'allPricesByTable']);

    Route::get('search-enterprise-name/{name_cnpj}', [EnterpriseController::class, 'getByNameCnpj']);
    
    Route::get('enterprise-search/{name_cnpj}', [EnterpriseController::class, 'getByNameCnpjMoreInfo']);

    Route::get('sub-categories', [CategoryController::class, 'subCategories']);

    
});

//test
Route::get('test', [EnterpriseController::class, 'test']);


// DELIVERY
Route::get('get-city/{zipcode}', [\App\Http\Controllers\API\DeliveryController::class, 'getCity']);
