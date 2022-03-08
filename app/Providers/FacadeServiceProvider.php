<?php

namespace App\Providers;

use App\Services\KaldikService;
use App\Services\ProtaService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('prota', function(){
            return new ProtaService;
        });
        App::bind('kaldik', function(){
            return new KaldikService;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
