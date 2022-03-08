<?php

namespace App\Services;

use App\Models\Pembelajaran;
use Illuminate\Support\Facades\Facade;

class PembelajaranService  {

  public function getByTingkat($tingkat)
  {
    $pembelajarans = Pembelajaran::where('tingkat', $tingkat)->get();
    return $pembelajarans;
  }

  public function show($ke, $tingkat)
  {
    $pembelajaran = Pembelajaran::where([
      ['ke','=',$ke],
      ['tingkat', '=',$tingkat]
    ])->first();

    return $pembelajaran;
  }
  
}