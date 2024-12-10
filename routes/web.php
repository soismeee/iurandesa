<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->middleware('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/getDashbaord', [HomeController::class, 'getDashbaord'])->middleware('auth');

// route web untuk backend
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('aksilogin');
Route::post('/aksilogin', [AuthController::class, 'authenticate'])->name('aksilogin');

Route::get('/getIuran', [HomeController::class, 'getIuran'])->middleware('auth');


Route::resource('/kategori', KategoriController::class)->middleware('auth');
Route::post('/jsonKategori', [KategoriController::class, 'json'])->middleware('auth');
Route::post('/delkategori/{id}', [KategoriController::class, 'destroy'])->middleware('auth');

Route::resource('/warga', WargaController::class)->middleware('auth');
Route::get('/getWarga', [WargaController::class, 'getWarga'])->middleware('auth');
Route::post('/jsonWarga', [WargaController::class, 'json'])->middleware('auth');

Route::get('/daftar_iuran',[IuranController::class, 'index'])->middleware('auth');
Route::get('/input_iuran',[IuranController::class, 'create'])->middleware('auth');
Route::get('/rekap',[IuranController::class, 'rekap'])->middleware('auth');
Route::post('/saveIuran', [IuranController::class, 'store'])->middleware('auth');
Route::post('/jsonHariIni', [IuranController::class, 'jsonhariIni'])->middleware('auth');
Route::post('/jsonAllIuran', [IuranController::class, 'jsonAll'])->middleware('auth');
Route::patch('/changeIuran/{id}', [IuranController::class, 'update'])->middleware('auth');
Route::delete('/getIuran/{id}', [IuranController::class, 'destroy'])->middleware('auth');

Route::get('/rekap_iuran', [IuranController::class, 'rekap'])->middleware('auth');
Route::post('/jsonRekap', [IuranController::class, 'jsonRekap'])->middleware('auth');