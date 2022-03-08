<?php

namespace App\Services;

use App\Models\Prota;
use Illuminate\Support\Facades\DB;

class ProtaService {
  public function getByTingkat($semester, $tingkat)
  {
    // $kds = DB::table('kds')
    //         ->where('tingkat', $tingkat);
    $protas = DB::table('protas')
              ->where([
                ['semester','=',$semester],
                ['tingkat','=', $tingkat]
              ])
              // ->joinSub($kds, 'kds', function($join)  {
              //   $join->whereIn('kds.kode_kd', explode(',', 'prota.kd'));
              // })
              ->get();

    return $protas;
  }
}