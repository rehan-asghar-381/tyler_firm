<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PriceController;

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
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/post-login', function () {
    return redirect()->route('login');
});
Route::get('admin', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

/* Start Admin Routes */
Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function() {
    /* Start Dashboard Routes */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    /* End Dashboard Routes */
    Route::get('users/ajax', [UserController::class, 'ajaxtData'])->name("users.ajax_data");
    Route::resource('users', UserController::class);
    /* Start Roles Routes */
    Route::get('roles/ajax',  [RoleController::class, 'ajaxtData'])->name("roles.ajax_data");
    Route::resource('roles', RoleController::class);
    /* Start Brand Routes */
    Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/brand/ajaxData', [BrandController::class, 'ajaxtData'])->name('brand.ajax_data');
    Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/brand/edit/{brand_id}', [BrandController::class, 'edit'])->name('brand.edit');
    Route::post('/brand/update/{brand_id}', [BrandController::class, 'update'])->name('brand.update');
    Route::get('/brand/show/{brand_id}', [BrandController::class, 'brandDetail'])->name('brand.detail');
    Route::get('/brand/delete-image', [BrandController::class, 'delete_image'])->name('brand.delete-image');
    /* Start Products Routes */
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/ajaxData', [ProductController::class, 'ajaxtData'])->name('product.ajax_data');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/edit/{product_id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{product_id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/show/{product_id}', [ProductController::class, 'productDetail'])->name('product.detail');
    Route::get('/product/delete-image', [ProductController::class, 'delete_image'])->name('product.delete-image');

    /* Start Product Variants Routes */
    Route::get('/product/variants', [ProductController::class, 'variants'])->name('product.variants');
    Route::get('/product/add-variant', [ProductController::class, 'add_variant'])->name('product.add-variant');
    Route::get('/product/delete-variant', [ProductController::class, 'delete_variant'])->name('product.delete-variant');
    Route::get('/product/add-attribute', [ProductController::class, 'add_attribute'])->name('product.add-attribute');
    Route::get('/product/attributes', [ProductController::class, 'attributes'])->name('product.attributes');
    Route::get('/product/delete-attribute', [ProductController::class, 'delete_attribute'])->name('product.delete-attribute');
    /* Start Clients Routes */
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/ajaxData', [ClientController::class, 'ajaxtData'])->name('clients.ajax_data');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients/store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/edit/{client_id}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::post('/clients/update/{client_id}', [ClientController::class, 'update'])->name('clients.update');


    /* Start Order Routes */

    
    Route::get('/clients/get_client', [ClientController::class, 'get_client'])->name('client.get_client');
    Route::get('/clients/add_client', [ClientController::class, 'add_client'])->name('client.add_client');
    Route::get('/order/get_client_recent_order', [OrderController::class, 'get_client_recent_order'])->name('order.get_client_recent_order');


    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/ajaxData', [OrderController::class, 'ajaxtData'])->name('orders.ajaxdata');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders/edit/{order_id}', [OrderController::class, 'edit'])->name('order.edit');
    Route::post('/orders/update/{order_id}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/product', [OrderController::class, 'product_form'])->name('order.product');
    Route::get('/orders/product_final_price_form', [OrderController::class, 'product_final_price_form'])->name('order.product_final_price_form');

    Route::get('/orders/view/{order_id}', [OrderController::class, 'orderView'])->name('order.view');


    Route::get('/get_decoration_price', [OrderController::class, 'get_decoration_price'])->name('get_decoration_price');

    Route::get('/get_product_by_brand', [ProductController::class, 'get_product_by_brand'])->name('get_product_by_brand');

      // Start General Setting Routes 
    Route::get('/settings/decoration-prices', [PriceController::class, 'index'])->name('price.index');
    Route::get('/settings/decoration-prices/edit', [PriceController::class, 'edit'])->name('price.edit');
    Route::post('/settings/decoration-prices/update', [PriceController::class, 'update'])->name('price.update');
    
}); 
/* End Admin Routes */

