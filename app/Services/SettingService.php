<?php
namespace App\Services;

use App\Models\Periode;

class SettingService {
  public function periode()
  {
    $periodes = Periode::orderBy('kode_periode', 'ASC')->get();
    return $periodes;
  }

  public function statusPeriode($id, $status)
  {
    Periode::whereNotIn('id',[$id])->update(['active' => 0]);
    $periode = Periode::where('id',$id)->update(['active' => 1]);
    return $periode;
  }
  public function storePeriode($input)
  {
    $periode = Periode::updateOrCreate(
      [
        'id' => $input['id'] ?? null,
        'kode_periode' => $input['kode_periode'],
        'tapel' => $input['tapel'], 
        'semester' => $input['semester'],
      ],
      [
        'label' => $input['label'],
        'active' => $input['active'] ?? 0,
      ]
    );

    return $periode;
  }
}