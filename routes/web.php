<?php

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchOrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ChangeStatusController;
use App\Http\Controllers\UserController;

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

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/create', [UserController::class, 'create']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/{user:id}', [UserController::class, 'destroy']);
Route::get('/profile', [UserController::class, 'show']);
Route::post('/update-user/{user:username}', [UserController::class, 'update']);

Route::resource('/product', ProductController::class);

Route::resource('/category', CategoryController::class);

Route::resource('/customer', CustomerController::class);

Route::resource('/order', OrderController::class);

Route::get('/transaction/checkout-now', [TransactionController::class, 'checkoutNow']);
Route::get('/transaction/pay-order/{order:code}', [TransactionController::class, 'payOrder']);
Route::resource('/transaction', TransactionController::class);
Route::post('/transaction/pay-now', [TransactionController::class, 'payNow']);
Route::get('/transaction/invoice/{code}', [TransactionController::class, 'template'])->name('invoice.print');
Route::post('/add-to-selected-order/{order}', [TransactionController::class, 'addToSelectedOrder'])->name('add.selected.order');
Route::post('/remove-from-selected-order/{order}', [TransactionController::class, 'removeFromSelectedOrder'])->name('remove.selected.order');