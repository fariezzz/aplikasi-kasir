<?php

use App\Http\Controllers\CategoryController;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ChangeStatusController;
use App\Http\Controllers\CustomerController;

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
    return view('pages.index', ['title' => 'Home'], [
        'transactions' => Transaction::all(),
        'products' => Product::all()
    ]);
})->middleware('auth');

Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'register'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::resource('/product', ProductController::class);

Route::resource('/category', CategoryController::class);

Route::resource('/customer', CustomerController::class);

Route::resource('/order', OrderController::class);
Route::put('/change-status/{id}', [ChangeStatusController::class, 'changeStatus']);

Route::resource('/transaction', TransactionController::class);