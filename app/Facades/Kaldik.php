<?php

namespace App\Facades;

use App\Services\KaldikService;
use Illuminate\Support\Facades\Facade;

class Kaldik extends Facade {
  protected static function getFacadeAccessor()
  {
    return KaldikService::class;
  }
}