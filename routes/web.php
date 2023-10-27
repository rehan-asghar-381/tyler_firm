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
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\PublicController;
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

Route::get('/password/reset', [AuthController::class, 'forgetPassword'])->name('password.reset'); 
Route::post('/user/password-reset', [AuthController::class, 'passwordReset'])->name('user.passwordReset'); 


Route::get('admin', [AuthController::class, 'index'])->name('login');

Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
/* Start Admin Routes */
Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function() {
    /* Start Dashboard Routes */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notfications', [DashboardController::class, 'get_notifications'])->name('dashboard.get_notifications');
    Route::get('/all-notfications', [DashboardController::class, 'all_notifications'])->name('dashboard.get_all_notifications');
    Route::get('/all-notfications/ajax', [DashboardController::class, 'notificationAjaxData'])->name('dashboard.notificationAjaxData');
    Route::get('/notification-seen-by', [DashboardController::class, 'notification_seeb_by'])->name('dashboard.notification_seeb_by');
    Route::get('/notifications/delete', [DashboardController::class, 'destroy'])->name('dashboard.deleteNotifications');
    /* End Dashboard Routes */
    Route::get('/change-password',  [AuthController::class, 'changePassword'])->name('changePassword'); 
    Route::post('/change-password-save',  [AuthController::class, 'changePasswordSave'])->name('changePasswordSave');

    Route::get('users/ajax', [UserController::class, 'ajaxtData'])->name("users.ajax_data");
    Route::post('users/update-user/{user_id}', [UserController::class, 'update'])->name("users.update-user");
    Route::get('users/delete/{user_id}', [UserController::class, 'destroy'])->name("users.delete");
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
    Route::get('/product/prices', [ProductController::class, 'prices'])->name('product.prices');
    Route::post('/product/save-prices', [ProductController::class, 'savePrices'])->name('product.save-prices');
    Route::get('/product/get-price', [ProductController::class, 'get_price'])->name('product.get_price');
    Route::get('/product/add-variant', [ProductController::class, 'add_variant'])->name('product.add-variant');
    Route::get('/product/delete-variant', [ProductController::class, 'delete_variant'])->name('product.delete-variant');
    Route::get('/product/add-attribute', [ProductController::class, 'add_attribute'])->name('product.add-attribute');
    Route::get('/product/attributes', [ProductController::class, 'attributes'])->name('product.attributes');
    Route::get('/product/delete-attribute', [ProductController::class, 'delete_attribute'])->name('product.delete-attribute');
    /* Start Clients Routes */
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/ajaxData', [ClientController::class, 'ajaxtData'])->name('clients.ajax_data');
    Route::get('/clients/order-history-data', [ClientController::class, 'ajaxClientsOrderHistory'])->name('clients.ajaxClientsOrderHistory');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients/store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/edit/{client_id}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::post('/clients/update/{client_id}', [ClientController::class, 'update'])->name('clients.update');
    Route::get('/clients/delete-doc', [ClientController::class, 'delete_doc'])->name('clients.delete-doc');
    Route::get('/clients/show/{product_id}', [ClientController::class, 'clientDetail'])->name('client.detail');
    Route::get('/clients/previous-order/{client_id}', [ClientController::class, 'previousOrder'])->name('client.previousOrder');
    /* Start Order Routes */
    Route::get('/clients/get_client', [ClientController::class, 'get_client'])->name('client.get_client');
    Route::get('/clients/add_client', [ClientController::class, 'add_client'])->name('client.add_client');
    Route::get('/clients/get_sales_rep', [ClientController::class, 'get_sales_rep'])->name('client.get_sales_rep');
    Route::get('/order/get_client_recent_order', [OrderController::class, 'get_client_recent_order'])->name('order.get_client_recent_order');


    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/ajaxData', [OrderController::class, 'ajaxtData'])->name('orders.ajaxdata');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders/edit/{order_id}', [OrderController::class, 'edit'])->name('order.edit');
    Route::get('/orders/delete/{order_id}', [OrderController::class, 'destroy'])->name('order.delete');
    Route::get('/orders/print_nd_loations/view', [OrderController::class, 'print_nd_loations_view'])->name('order.print_nd_loations_view');
    Route::post('/orders/update/{order_id}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/product', [OrderController::class, 'product_form'])->name('order.product');
    Route::get('/orders/print_nd_loations', [OrderController::class, 'print_nd_loations'])->name('order.print_nd_loations');
    Route::get('/orders/view/{order_id}', [OrderController::class, 'orderView'])->name('order.view');
    Route::get('/orders/status_update', [OrderController::class, 'status_update'])->name('order.status_update');
    Route::get('/orders/quote_update', [OrderController::class, 'quote_update'])->name('order.quote_update');
    Route::get('/orders/blank_update', [OrderController::class, 'blank_update'])->name('order.blank_update');
    Route::get('/orders/generate_invoice/{order_id}', [OrderController::class, 'generateInvoice'])->name('order.generateInvoice');
    Route::get('/orders/recreate/{order_id}', [OrderController::class, 'recreate'])->name('order.recreate');
    Route::get('/order/delete-image', [OrderController::class, 'delete_image'])->name('order.delete-image');
    Route::get('/orders/d_yellow/{order_id}', [OrderController::class, 'DYellow'])->name('order.DYellow');
    Route::post('/orders/d_yellow/store_d_yellow', [OrderController::class, 'storeDYellow'])->name('order.storeDYellow');
    Route::get('/email-template/email-popup', [OrderController::class, 'email_popup'])->name('email-template.email_popup');
    Route::get('/email-template/action-log', [OrderController::class, 'action_log_popup'])->name('email-template.action_log');
    Route::get('/email-template/action-log-seen', [OrderController::class, 'action_log_seen'])->name('email-template.action_log_seen');
    Route::post('/send-email', [OrderController::class, 'sendEmail'])->name('sendEmail');
    Route::get('/orders/download-art-files/{file_id}', [OrderController::class, 'downloadArtFiles'])->name('order.downloadArtFiles');
    Route::get('/orders/download-comp-files/{file_id}', [OrderController::class, 'downloadCompFiles'])->name('order.downloadCompFiles');
    Route::get('/order/approveComp', [OrderController::class, 'compApprove'])->name('order.approveComp');
    
    Route::get('/get_decoration_price', [OrderController::class, 'get_decoration_price'])->name('get_decoration_price');
    Route::get('/get_product_by_brand', [ProductController::class, 'get_product_by_brand'])->name('get_product_by_brand');
    // Start General Setting Routes 
    Route::get('/settings/decoration-prices', [PriceController::class, 'index'])->name('price.index');
    Route::get('/settings/decoration-prices/edit', [PriceController::class, 'edit'])->name('price.edit');
    Route::post('/settings/decoration-prices/update', [PriceController::class, 'update'])->name('price.update');
    /* Start Email Templates Routes */
    Route::get('/email-template', [EmailTemplateController::class, 'index'])->name('email-template.index');
    Route::get('/email-template/ajaxData', [EmailTemplateController::class, 'ajaxtData'])->name('email-template.ajax_data');
    Route::get('/email-template/create', [EmailTemplateController::class, 'create'])->name('email-template.create');
    Route::post('/email-template/store', [EmailTemplateController::class, 'store'])->name('email-template.store');
    Route::get('/email-template/edit/{temp_id}', [EmailTemplateController::class, 'edit'])->name('email-template.edit');
    Route::post('/email-template/update/{temp_id}', [EmailTemplateController::class, 'update'])->name('email-template.update');
    Route::post('/email-template/show/{temp_id}', [EmailTemplateController::class, 'show'])->name('email-template.show');
    
}); 
/* End Admin Routes */
/* Start Public Routes */
Route::get('/clients/quote/{order_id}/{email}', [PublicController::class, 'get_quote'])->name('order.quote');
Route::post('/clients/quote/store-response', [PublicController::class, 'store'])->name('quote.store');
/* End Public Routes */


