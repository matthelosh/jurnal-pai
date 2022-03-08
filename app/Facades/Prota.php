<?php

namespace App\Facades;

use App\Services\ProtaService;
use Illuminate\Support\Facades\Facade;

class Prota extends Facade {
  protected static function getFacadeAccessor()
  {
    return ProtaService::class;
  }
}