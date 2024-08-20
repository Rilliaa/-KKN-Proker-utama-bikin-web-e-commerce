<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TambahanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengaturanAkunController;


// Default route
Route::get('/', function () {
    return view('produk');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Authentication routes
Auth::routes();

// Home route for authenticated users
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// -----------------------------Rute untuk Produk-----------------------------//
Route::get('/admin-produk',[ProdukController::class,'index'])->name('admin.produk-index');
Route::post('/admin-produk-store', [ProdukController::class, 'store'])->name('admin.produk-store');
Route::put('/admin-produk-update/{id}', [ProdukController::class, 'update'])->name('admin.produk-update');
Route::delete('/admin-produk-delete/{id}', [ProdukController::class, 'destroy'])->name('admin.produk-destroy');
Route::get('/admin-produk-detail/{id}',[ProdukController::class,'show'])->name('admin.produk-show');
// -----------------------------Rute untuk Produk-----------------------------//




// -----------------------------Rute untuk Kategori-----------------------------//
Route::get('/admin-kategori',[KategoriController::class,'index'])->name('admin.kategori-index');
Route::post('/admin-kategori', [KategoriController::class, 'store'])->name('admin.kategori-store');
Route::put('/admin-kategori-update/{id}', [KategoriController::class, 'update'])->name('admin.kategori-update');
Route::delete('/admin-kategori-destroy/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori-destroy');
Route::get('/admin-kategori-search',[KategoriController::class,'search'])->name('admin.kategori-search');
Route::get('/admin-kategori-dropdown',[KategoriController::class,'dropdown'])->name('admin.kategori-dropdown');
// -----------------------------Rute untuk Kategori-----------------------------//


// -----------------------------Rute untuk Tambahan-----------------------------//
Route::get('/admin-produk-tambahan/{id}',[TambahanController::class,'index'])->name('admin.tambahan-index');
Route::post('/admin-produk-tambahan-store',[TambahanController::class,'store'])->name('admin.tambahan-store');
// Route::put('/admin-produk-tambahan-update/{id}',[TambahanController::class,'update'])->name('admin.tambahan-update');
Route::post('/admin-produk-tambahan-update/{id}',[TambahanController::class,'update'])->name('admin.tambahan-update');
Route::delete('/admin-produk-tambahan-delete/{id}', [TambahanController::class, 'destroy'])->name('admin.tambahan-destroy'); //untuk hapus foto 
Route::delete('/admin-tambahan-delete-/{id}',[TambahanController::class,'delete'])->name('admin.tambahan-delete-all'); //untuk hapus semua data

// -----------------------------Rute untuk Tambahan-----------------------------//


// -----------------------------Rute untuk User-----------------------------//
Route::delete('/users/delete/{id}',[UserController::class,'destroy'])->name('user.destroy');
// -----------------------------Rute untuk User-----------------------------//


// -----------------------------Rute untuk Pengaturan Akun-----------------------------//
Route::get('/pengaturan-akun', [PengaturanAkunController::class,'index'])->name('pengaturanAkun.index');
Route::post('/pengaturan-akun/update-password', [PengaturanAkunController::class, 'updatePassword'])->name('password.update');
// -----------------------------Rute untuk Pengaturan Akun-----------------------------//




// -----------------------------Untuk Resource-----------------------------//
Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('auth');
Route::resource('kategori', \App\Http\Controllers\KategoriController::class)->middleware('auth');
Route::resource('tambahan', \App\Http\Controllers\TambahanController::class)->middleware('auth');
Route::resource('pengaturan-akun', \App\Http\Controllers\PengaturanAkunController::class)->middleware('auth');
// -----------------------------Untuk Resource-----------------------------//





// -----------------------------Untuk Middleware-----------------------------//
Route::middleware('auth')->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('kategori', App\Http\Controllers\KategoriController::class);
    Route::resource('tambahan', App\Http\Controllers\TambahanController::class);
});
// -----------------------------Untuk Middleware-----------------------------//

