<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserCategoriesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});


Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('product-categories', ProductCategoriesController::class);
    Route::get('/all-product-categories', [ProductCategoriesController::class,'getAllProductCategories'])->name('all_product_categories');
    Route::get('/products-by-category/{id}', [ProductController::class,'getAllProductByCategory'])->name('products_by_category');
    Route::get('/product-by-id/{id}', [ProductController::class,'getProductById'])->name('products_by_id');
    Route::resource('products', ProductController::class);
    Route::resource('event-logs', LogsController::class);
    Route::get('/event-logs/{id}','LogsController@getActivity')->name('log.get-activity');
    Route::resource('orders', OrdersController::class);
    Route::resource('customers', CustomersController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('users', UserController::class);

    Route::get('/all-user-categories', [UserCategoriesController::class,'getAllUserCategories'])->name('all_user_categories');
    Route::get('/all-user-roles', [RolesController::class,'getAllUserRoles'])->name('all_user_roles');

    Route::get('/all-customers', [CustomersController::class,'getAllCustomers'])->name('all_customers');
    Route::get('/customer-by-id/{id}', [CustomersController::class,'getCustomerById'])->name('customer_by_id');



});


