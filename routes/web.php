<?php

use App\Http\Controllers\SalesController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/dashboard', '/sales');

Route::get('/sales', 'App\Http\Controllers\SalesController@index')->middleware(['auth'])->name('coffee.sales');
Route::post('/sales', 'App\Http\Controllers\SalesController@store')->middleware(['auth'])->name('store.sales');

Route::get('/shipping-partners', 'App\Http\Controllers\ShipmentCostController@index')->middleware(['auth'])->name('shipping.partners');
Route::post('/shipping-partners', 'App\Http\Controllers\ShipmentCostController@store')->middleware(['auth'])->name('store.shipment');

require __DIR__.'/auth.php';
