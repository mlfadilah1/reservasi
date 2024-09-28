<?php

use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('landing');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('landing');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/menus', [App\Http\Controllers\MenuController::class, 'index'])->name('menus');


Auth::routes();
Route::middleware(['auth','Admin', 'Kasir'])->group(function(){
    //menu
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/menu', [App\Http\Controllers\MenuController::class, 'index'])->name('menu');
    Route::get('/tambahmenu', [App\Http\Controllers\MenuController::class, 'tambah'])->name('tambahmenu');
    Route::post('/submit', [App\Http\Controllers\MenuController::class, 'submit'])->name('submit');
    Route::post('/updatemenu{id}', [App\Http\Controllers\MenuController::class, 'updatemenu'])->name('updatemenu');
    Route::get('/editmenu{id_menu}', [App\Http\Controllers\MenuController::class, 'editmenu'])->name('editmenu');
    Route::get('/deletemenu/{id_menu}',[App\Http\Controllers\MenuController::class, 'deletemenu'])->name('deletemenu');
    Route::get('/detailmenu/{id_menu}', [App\Http\Controllers\HomeController::class, 'detailmenu'])->name('detailmenu');
    //Laporan Reeservasi
    Route::get('/laporanreservasi', [App\Http\Controllers\ReservasiController::class, 'laporan'])->name('laporanreservasi');
    Route::get('/laporanharian', [App\Http\Controllers\ReservasiController::class, 'laporanharian'])->name('laporanharian');
    Route::get('/hapusreservasi/{id_reservasi}', [App\Http\Controllers\ReservasiController::class, 'hapusreservasi'])->name('hapusreservasi');
    //Transaksi
    Route::get('/transaksi', [App\Http\Controllers\TransaksiController::class, 'index'])->name('transaksi');
    Route::put('/updatereservasi/{id_reservasi}',[App\Http\Controllers\TransaksiController::class, 'updatereservasi'])->name('updatereservasi');
    //Data Pembeli
    Route::get('/pembeli', [App\Http\Controllers\PembeliController::class, 'index'])->name('pembeli');
    //Rating / ulasan
    Route::get('/rating', [App\Http\Controllers\RatingController::class, 'index'])->name('rating');
    //kasir
    Route::get('/kasir', [App\Http\Controllers\KasirController::class, 'index'])->name('kasir');
    Route::get('/tambahkasir', [App\Http\Controllers\KasirController::class, 'tambah'])->name('tambahkasir');
    Route::post('/submitkasir', [App\Http\Controllers\KasirController::class, 'submitkasir'])->name('submitkasir');
    //meja
    Route::get('/meja', [App\Http\Controllers\PembeliController::class, 'meja'])->name('meja');
    Route::get('/tambahmeja', [App\Http\Controllers\PembeliController::class, 'tambah'])->name('tambahmeja');
    Route::post('/submitmeja', [App\Http\Controllers\PembeliController::class, 'submitmeja'])->name('submitmeja');
    Route::post('/updatemeja{id}', [App\Http\Controllers\PembeliController::class, 'updatemeja'])->name('updatemeja');
    Route::get('/editmeja{id_meja}', [App\Http\Controllers\PembeliController::class, 'editmeja'])->name('editmeja');
    Route::get('/deletemeja/{id_meja}',[App\Http\Controllers\PembeliController::class, 'deletemeja'])->name('deletemeja');
    Route::put('/updateMejaStatus/{id_meja}',[App\Http\Controllers\PembeliController::class, 'updateMejaStatus'])->name('updateMejaStatus');

});

Route::middleware(['auth','Customer'])->group(function(){
    Route::get('/dashboard', [App\Http\Controllers\LandingController::class, 'dashboard'])->name('dashboard');
    Route::get('/demo', [App\Http\Controllers\LandingController::class, 'demo'])->name('demo');
    Route::get('/reservasi', [App\Http\Controllers\ReservasiController::class, 'reservasi'])->name('reservasi');
    Route::post('/submitreservasi', [App\Http\Controllers\ReservasiController::class, 'submitreservasi'])->name('submitreservasi');
    Route::post('/tambah', [App\Http\Controllers\LandingController::class, 'tambah'])->name('tambah');
    Route::get('/hapusorder/{razan}', [App\Http\Controllers\ReservasiController::class, 'hapusorder'])->name('hapusorder');
    Route::post('/tambahorder/{datadetail}', [App\Http\Controllers\ReservasiController::class,'tambahorder'])->name('tambahorder');
    Route::post('/checkout', [App\Http\Controllers\ReservasiController::class, 'checkout'])->name('checkout');
    Route::get('/pesanan', [App\Http\Controllers\MenuController::class, 'pesanan'])->name('pesanan');
    Route::get('/detailpesanan/{id_reservasi}', [App\Http\Controllers\TransaksiController::class, 'detailpesanan'])->name('detailpesanan');
    Route::post('/detailpesanan', [App\Http\Controllers\TransaksiController::class, 'detail']);
    Route::get('/review{id_menu}', [App\Http\Controllers\RatingController::class, 'review'])->name('review');
    Route::post('/submitrating/{id_menu}', [App\Http\Controllers\RatingController::class, 'submitrating'])->name('submitrating');
    
});