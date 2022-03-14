<?php

namespace App\Providers;

use App\Services\RpeService;
use App\Services\ProtaService;
use App\Services\KaldikService;
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
        App::bind('rpe', function() {
            return new RpeService;
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
