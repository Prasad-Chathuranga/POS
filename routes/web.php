<?php

use App\Http\Controllers\LogsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductCategoriesController;
use App\Http\Controllers\ProductController;
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



});


