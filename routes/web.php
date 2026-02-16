<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Main\BukuController;
use App\Http\Controllers\Main\KategoriController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');

    // buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku/store', [BukuController::class, 'store'])->name('buku.store');
});
