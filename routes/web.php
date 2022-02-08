<?php
namespace App\Http\Controllers;
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

    Route::middleware('auth:sanctum')->group(function(){
        Route::group(['prefix' => 'dashboard'], function(){
            Route::get('/', [DashController::class, 'index'])->name('dashboard');
        });

        // admin
        Route::group(['prefix' => 'admin'], function(){
            Route::group(['prefix' => 'jurnal'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.jurnal');
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
            Route::group(['prefix' => 'jurnal'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.jurnal');
            });
            Route::group(['prefix' => 'sekolah'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.sekolah');
            });
            Route::group(['prefix' => 'rombel'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.rombel');
            });
            Route::group(['prefix' => 'settings'], function(){
                Route::get('/', [DashController::class, 'index'])->name('admin.settings');
            });
        });
    });
