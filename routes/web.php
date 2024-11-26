<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InstallationsController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\UserController;
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
    return view('welcome')->with('title','Dashboard');
});

// Auth
Route::post('/auth', [AuthController::class, 'login']);

// Accounts || Rekening
Route::resource('/accounts', AccountController::class);

// Business || Usaha
Route::resource('/business', BusinessController::class);

// Customers || Pelanggan
Route::resource('/customers', CustomerController::class);
// GET /customers                   index
// POST /customers                  store
// GET /customers/create            create
// GET /customers/{id}              show
// GET /customers/{id}/edit         edit
// PUT /customers/{id}              update
// DELETE /customers/{id}           destroy

// Installations || Instalasi
Route::resource('/installations', InstallationsController::class);
Route::get('/installations/jenis_paket/{id}', [InstallationsController::class, 'janis_paket']);
Route::get('installations/generatekode_istalasi', [InstallationsController::class, 'generatekode_istalasi']);


// Packages || Paket
Route::resource('/packages', PackageController::class);

// Transactions || Transaksi
Route::resource('/transactions', TransactionController::class);

// Usages || Penggunaan
Route::resource('/usages', UsageController::class);

// Users || Pengguna
Route::resource('/users', UserController::class);
