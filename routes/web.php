<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InstallationsController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SopController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\UserController;
<<<<<<< HEAD
=======
use App\Http\Controllers\VillageController;
use App\Models\Installations;
>>>>>>> 6e9fef6eb3dc134d8c4fceaebeb662c0e9df7e6a
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
Route::get('/installations/jenis_paket/{id}', [InstallationsController::class, 'janis_paket']);
Route::get('/installations/kode_instalasi', [InstallationsController::class, 'kode_instalasi']);
Route::get('/installations/pelunasan_instalasi', [InstallationsController::class, 'pelunasan_instalasi']);
Route::resource('/installations', InstallationsController::class);


// Packages || Paket
Route::resource('/packages', PackageController::class);

// Transactions || Transaksi
Route::resource('/transactions', TransactionController::class);

// Usages || Penggunaan
Route::resource('/usages', UsageController::class);

// Users || Pengguna
Route::resource('/users', UserController::class);

// Users || Desa
Route::resource('/villages', VillageController::class);

Route::get('/pengaturan/sop', [SopController::class, 'profil']);
Route::get('/pengaturan/sop/create', [SopController::class, 'create_paket']);

<<<<<<< HEAD
Route::get('/detail/{perguliran}', [InstallationsController::class, 'detail'])->middleware('auth');
=======
Route::get('/detail/{perguliran}', [Installations::class, 'detail'])->middleware('auth');


>>>>>>> 6e9fef6eb3dc134d8c4fceaebeb662c0e9df7e6a
