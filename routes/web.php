<?php

use App\Http\Controllers\AjaxAxios\AdministrasiAjaxController;
use App\Http\Controllers\AjaxAxios\AdministrasiAxiosController;
use App\Http\Controllers\AjaxAxios\PenjualanAjaxController;
use App\Http\Controllers\AjaxAxios\PenjualanAxiosController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Main\BukuController;
use App\Http\Controllers\Main\KategoriController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
    // return view('auth.login');
});

Auth::routes();

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('verify-otp', [GoogleController::class, 'showOtpForm'])->name('otp.verify');
Route::post('verify-otp', [GoogleController::class, 'verifyOtp'])->name('otp.verify.post');

Route::middleware(['auth'])->group(function () {
    // home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/update', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/destroy', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku/store', [BukuController::class, 'store'])->name('buku.store');
    Route::put('/buku/update', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/destroy', [BukuController::class, 'destroy'])->name('buku.destroy');

    // pdf
    Route::get('/pdf/potrait', [PdfController::class, 'pdfPotrait'])->name('pdf.potrait');
    Route::get('/pdf/landscape', [PdfController::class, 'pdfLandscape'])->name('pdf.landscape');

    // barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang');
    Route::post('/barang/label', [BarangController::class, 'label'])->name('barang.label');

    // javascript
    Route::get('/javascript/itemjs', function () {
        return view('javascript.barangjs');
    })->name('js.barangjs');
    Route::get('/javascript/datatablesjs', function () {
        return view('javascript.datatablesjs');
    })->name('js.datatablesjs');
    Route::get('/javascript/kotajs', function () {
        return view('javascript.kotajs');
    })->name('js.kotajs');

    // ajax/axios
    Route::get('/ajax-axios/administrasiAjax', [AdministrasiAjaxController::class, 'index'])->name('administrasi.ajax');
    Route::post('/ajax-axios/administrasiAjax/get-kota', [AdministrasiAjaxController::class, 'getKota'])->name('administrasi.ajax.getKota');
    Route::post('/ajax-axios/administrasiAjax/get-kecamatan', [AdministrasiAjaxController::class, 'getKecamatan'])->name('administrasi.ajax.getKecamatan');
    Route::post('/ajax-axios/administrasiAjax/get-kelurahan', [AdministrasiAjaxController::class, 'getKelurahan'])->name('administrasi.ajax.getKelurahan');

    Route::get('/ajax-axios/administrasiAxios', [AdministrasiAxiosController::class, 'index'])->name('administrasi.axios');
    Route::post('/ajax-axios/administrasiAxios/get-kota', [AdministrasiAxiosController::class, 'getKota'])->name('administrasi.axios.getKota');
    Route::post('/ajax-axios/administrasiAxios/get-kecamatan', [AdministrasiAxiosController::class, 'getKecamatan'])->name('administrasi.axios.getKecamatan');
    Route::post('/ajax-axios/administrasiAxios/get-kelurahan', [AdministrasiAxiosController::class, 'getKelurahan'])->name('administrasi.axios.getKelurahan');

    Route::get('/ajax-axios/penjualanAjax', [PenjualanAjaxController::class, 'index'])->name('penjualan.ajax');
    Route::get('/ajax-axios/penjualanAjax/create', [PenjualanAjaxController::class, 'create'])->name('penjualan.ajax.create');
    Route::post('/ajax-axios/penjualanAjax/searchBarang', [PenjualanAjaxController::class, 'searchBarang'])->name('penjualan.ajax.search');
    Route::post('/ajax-axios/penjualanAjax/store', [PenjualanAjaxController::class, 'store'])->name('penjualan.ajax.store');
    Route::get('/ajax-axios/penjualanAjax/{id}/details', [PenjualanAjaxController::class, 'getDetails'])->name('penjualan.ajax.getDetails');


    Route::get('/ajax-axios/penjualanAxios', [PenjualanAxiosController::class, 'index'])->name('penjualan.axios');
    Route::get('/ajax-axios/penjualanAxios/create', [PenjualanAxiosController::class, 'create'])->name('penjualan.axios.create');
    Route::post('/ajax-axios/penjualanAxios/searchBarang', [PenjualanAxiosController::class, 'searchBarang'])->name('penjualan.axios.search');
    Route::post('/ajax-axios/penjualanAxios/store', [PenjualanAxiosController::class, 'store'])->name('penjualan.axios.store');
    Route::get('/ajax-axios/penjualanAxios/{id}/details', [PenjualanAjaxController::class, 'getDetails'])->name('penjualan.axios.getDetails');
});
