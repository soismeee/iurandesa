<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\WargaController;
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
Route::get('/', [HomeController::class, 'index'])->middleware('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// route web untuk backend
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('aksilogin');
Route::post('/aksilogin', [AuthController::class, 'authenticate'])->name('aksilogin');

Route::get('/getIuran', [HomeController::class, 'getIuran'])->middleware('auth');


Route::resource('/kategori', KategoriController::class)->middleware('auth');
Route::post('/jsonKategori', [KategoriController::class, 'json'])->middleware('auth');
Route::post('/delkategori/{id}', [KategoriController::class, 'destroy'])->middleware('auth');

Route::resource('/warga', WargaController::class)->middleware('auth');
Route::post('/jsonWarga', [WargaController::class, 'json'])->middleware('auth');

Route::get('/daftar_iuran',[IuranController::class, 'index'])->middleware('auth');
Route::get('/input_iuran',[IuranController::class, 'create'])->middleware('auth');

Route::get('/rekap_iuran', [IuranController::class, 'rekap'])->middleware('auth');