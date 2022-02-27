<?php

namespace App\Services;

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