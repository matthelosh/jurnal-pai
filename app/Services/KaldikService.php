<?php

namespace App\Services;

use App\Models\Kaldik;
use Illuminate\Support\Facades\DB;

class KaldikService {

  public function byTapel($tapel)
  {
    $kaldiks = Kaldik::where('tapel', $tapel)->get();
    return $kaldiks;
  }

  public function store($input)
  {
    $kaldik = Kaldik::updateOrCreate(
      [
        'id' => $input['id'] ?? null,
      ],
      [
        'detail' => $input['detail'],
        'end' => $input['end'],
        'guru_id' => $input['guruId'],
        'location' => $input['location'],
        'name' => $input['name'],
        'start' => $input['start'],
        'tapel' => $input['tapel'],
        'color' => $input['color']['hexa'] ?? $input['color']
      ]
      );
    return $kaldik;
  }
}