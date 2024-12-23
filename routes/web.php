<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HamletController;
use App\Http\Controllers\InstallationsController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\SopController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VillageController;
use App\Models\Installations;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
    Session::put('business_id', '1');
    return view('welcome')->with('title', 'Dashboard');
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
// GET /customers/{customer}              show
// GET /customers/{customer}/edit         edit
// PUT /customers/{customer}              update
// DELETE /customers/{customer}           destroy

// Installations || Instalasi
Route::get('/installations/reg_notifikasi/{customer_id}', [InstallationsController::class, 'reg_notifikasi']);
Route::get('/installations/jenis_paket/{id}', [InstallationsController::class, 'jenis_paket']);
Route::get('/installations/kode_instalasi', [InstallationsController::class, 'kode_instalasi']);
Route::get('/installations/cari_Custommers', [InstallationsController::class, 'cariCustomers']);
Route::resource('/installations', InstallationsController::class);


// Packages || Paket
Route::get('/packages/block_paket', [PackageController::class, 'block_paket']);
Route::resource('/packages', PackageController::class);

// Transactions || Transaksi
Route::get('/transactions/pelunasan_instalasi', [TransactionController::class, 'pelunasan_instalasi']);
Route::resource('/transactions', TransactionController::class);

// Usages || Penggunaan
Route::get('/usages/cari_anggota', [UsageController::class, 'carianggota']);
Route::resource('/usages', UsageController::class);


// Users || Pengguna
Route::resource('/users', UserController::class);

// Users || Desa
Route::get('/ambil_kab/{kode}', [VillageController::class, 'ambil_kab']);
Route::get('/ambil_kec/{kode}', [VillageController::class, 'ambil_kec']);
Route::get('/ambil_desa/{kode}', [VillageController::class, 'ambil_desa']);
Route::get('/set_alamat/{kode}', [VillageController::class, 'generateAlamat']);
Route::resource('/villages', VillageController::class);
Route::delete('/villages/{village}', [VillageController::class, 'destroy']);

// Dusun
Route::resource('/hamlets', HamletController::class);
Route::delete('/hamlets/{hamlet}', [HamletController::class, 'destroy']);




Route::resource('/pengaturan', SopController::class);
Route::get('/pengaturan/sop', [SopController::class, 'profil']);
Route::get('/pengaturan/sop/pasang_baru', [SopController::class, 'pasang_baru']);
Route::get('/pengaturan/sop/block_paket', [SopController::class, 'block_paket']);

Route::get('/generate_alamat/{kode}', [VillageController::class, 'generateAlamat']);
