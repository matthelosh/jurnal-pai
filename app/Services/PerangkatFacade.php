<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class PerangkatFacade extends Facade {

  protected static function getFacadeAccessor()
  {
    return PerangkatService::class;
  }
}