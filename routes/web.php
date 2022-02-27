<?php
namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('/', [FrontController::class, 'home'])->name('home');
    Route::get('/tentang', [FrontController::class, 'about'])->name('about');
    Route::get('/login', [FrontController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function(){
        Route::group(['prefix' => 'dashboard'], function(){
            Route::get('/', [DashController::class, 'index'])->name('dashboard');
        });

        // admin
        Route::prefix('admin')->middleware('role:admin')->group(function() {
            Route::group(['prefix' => 'dashboard'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.dashboard');
            });
            Route::group(['prefix' => 'jurnal'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.jurnal');
            });

            Route::group(['prefix' => 'kd'], function() {
                Route::post('/', [KdController::class, 'index'])->name('admin.kd.index');
            });
            Route::group(['prefix' => 'guru'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.guru');
                Route::post('/', [GuruController::class, 'index'])->name('admin.guru.index');
                Route::delete('/', [GuruController::class, 'destroySome'])->name('admin.guru.destroy-some');
                Route::post('/store', [GuruController::class, 'store'])->name('admin.guru.store');
                Route::post('/buatakun', [GuruController::class, 'createAccount'])->name('admin.guru.buatakun');
                Route::post('/impor', [GuruController::class, 'impor'])->name('admin.guru.impor');
                Route::delete('/{id}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');
            });
            Route::group(['prefix' => 'jadwal'], function() {
                Route::get('/', [DashController::class, 'index'])->name('admin.jadwal');
            });
            Route::group(['prefix' => 'jurnal'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.jurnal');
            });
            Route::group(['prefix' => 'sekolah'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.sekolah');
                Route::post('/', [SekolahController::class, 'index'])->name('admin.sekolah.index');
                Route::post('/store', [SekolahController::class, 'store'])->name('admin.sekolah.store');
            });
            Route::group(['prefix' => 'rombel'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.rombel');
            });
            Route::group(['prefix' => 'settings'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.settings');
                Route::post('/periode', [SettingController::class, 'periode'])->name('admin.settings.periode');
                Route::post('/periode/store', [SettingController::class, 'storePeriode'])->name('admin.settings.periode.store');
                Route::put('/periode/status', [SettingController::class, 'StatusPeriode'])->name('admin.settings.periode.status');

            });
            Route::group(['prefix' => 'perangkat'], function() {    
                Route::get('/', [DashController::class, 'index'])->name('admin.perangkat');
                Route::post('/get', [PerangkatController::class, 'get'])->name('admin.perangkat.get');
                // Route::post('/pembelajaran', [PerangkatController::class, 'indexPbl'])->name('admin.perangkat.pembelajaran.store');
                Route::post('/pembelajaran/store', [PerangkatController::class, 'storePbl'])->name('admin.perangkat.pembelajaran.store');
            });

            Route::group(['prefix' => 'menu'], function() {
                Route::post('/', [MenuController::class, 'index'])->name('admin.menu');
                Route::post('/store', [MenuController::class, 'store'])->name('admin.menu.store');
                Route::delete('/{id}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
            });
        });

        // Guru 
        Route::prefix('guru')->middleware('role:guru')->group(function() {
            Route::group(['prefix' => 'dashboard'], function(){
                Route::get('/', [DashController::class, 'index'])->name('guru.dashboard');
            });
            Route::group(['prefix' => 'jurnal'], function() {
                Route::get('/', [DashController::class, 'index'])->name('guru.jurnal');
            });
            Route::group(['prefix' => 'sekolah'], function() {
                Route::get('/', [DashController::class, 'index'])->name('guru.sekolah');
                Route::put('/', [SekolahController::class, 'store'])->name('guru.sekolah.store');
                Route::post('/{npsn}', [SekolahController::class, 'show'])->name('guru.sekolah.show');
            });

            Route::group(['prefix' => 'pembelajaran'], function() {
                Route::post('/', [PembelajaranController::class, 'getByTingkat'])->name('guru.pembelajaran.bytingkat');
            });

            Route::group(['prefix' => 'agenda'], function() {
                Route::get('/', [DashController::class, 'index'])->name('guru.agenda');
            });
            Route::group(['prefix' => 'jadwal'], function() {
                Route::get('/', [DashController::class, 'index'])->name('guru.jadwal');
                Route::post('/store', [JadwalController::class, 'store'])->name('guru.jadwal.store');
                Route::post('/show', [JadwalController::class, 'show'])->name('guru.jadwal.show');
                Route::post('/{guruId}', [JadwalController::class, 'index'])->name('guru.jadwal.index');
            });
            Route::group(['prefix' => 'rombel'], function() {
                Route::get('/', [DashController::class, 'index'])->name('guru.rombel');
                Route::post('/store', [RombelController::class, 'store'])->name('guru.rombel.store');
                Route::post('/{guruId}', [RombelController::class, 'index'])->name('guru.rombel.index');
                Route::delete('/{id}', [RombelController::class, 'destroy'])->name('guru.rombel.destroy');
            });
        });
    });
