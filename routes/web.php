<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\ProductController;

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
    return view('basic');
})->name('basic');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/receipt', [ProductController::class, 'showReceipt'])->name('receipt');

Route::get('/wait', [ProductController::class, 'showWaitScreen'])->name('wait');

Route::get('/search', [ProductController::class, 'search']);
Route::post('/search', [ProductController::class, 'search'])->name('search');


Route::get('/payment', [ProductController::class, 'payment'])->name('payment');
Route::post('/process-payment', [ProductController::class, 'processPayment'])->name('process-payment');
Route::get('/empty-cart', [ProductController::class, 'emptyCart'])->name('empty-cart');

Route::post('/product/register', [ProductController::class, 'register'])->name('product.register');

Route::post('/product/update', [ProductController::class, 'registerUpdate'])->name('product.update');

Route::get('/product/cancel', [ProductController::class, 'registerCansel'])->name('product.cansel');

Route::get('/show-earnings', [ProductController::class, 'showEarnings'])->name('show-earnings');

Route::get('/confirm-earnings', [ProductController::class, 'confirmEarnings'])->name('confirm-earnings');

//カートの中身いじる軍団のルーティング
Route::get('/showcart', [ProductController::class, 'showCart'])->name('showcart');
Route::get('/correctioncart/{id}', [ProductController::class, 'correctionCart'])->name('correctioncart');
Route::post('/updatecart/{id}', [ProductController::class, 'updateCart'])->name('updatecart');
Route::delete('/deletecart/{id}', [ProductController::class, 'deleteCart'])->name('deletecart');
Route::get('/result2', [ProductController::class, 'returnResult'])->name('result2');
