<?php

namespace App\Services;

use App\Models\Indikator;
use App\Models\Kd;
use App\Models\Pembelajaran;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Session;

class PerangkatService  {

  public function getKd($tingkat)
  {
    $kds = Kd::where('tingkat',$tingkat)->get();
    return $kds;
  }

  public function getPbl()
  {
    $pbl = Pembelajaran::all();
    return $pbl;
  }

  public function getIndikator($tingkat, $kds)
  {
    $indikators = Indikator::where('tingkat', $tingkat)->whereIn('kd_id', $kds)->get();;
    return $indikators;
  }

  public function storePbl($input)
  {
    $pembelajaran = Pembelajaran::updateOrCreate(
      [
        'id' => $input['id'] ?? null,
      ],
      [
        'tapel' => $input['tapel'] ?? Session::get('periode')['tapel'],
        'kd_id' => $input['kd_id'] ? implode(",", $input['kd_id']) : null,
        'semester' => $input['semester'] ?? Session::get('periode')['semester'],
        'tingkat' => $input['tingkat'] ?? null,
        'ke' => $input['ke'] ?? null,
        'judul' => $input['judul'] ?? null,
        'sub' => $input['sub'] ?? null,
      ]
    );

    return $pembelajaran;
  }
  
}