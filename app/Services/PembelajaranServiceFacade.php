<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class PembelajaranServiceFacade extends Facade {

  protected static function getFacadeAccessor()
  {
    return PembelajaranService::class;
  }
}