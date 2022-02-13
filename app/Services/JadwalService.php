<?php
namespace App\Services;

use App\Models\Jadwal;

class JadwalService {
  
  public function index($role, $guruId, $periode)
  {
    if ($role == 'admin') {
      return Jadwal::where('periode', 1)->orderBy('created_at', 'DESC')->get();
    } else {
      return Jadwal::where(
        [
          ['guru_id', '=', $guruId],
          ['periode_id','=',$periode]
        ]
        )->with('rombel')->orderBy('created_at', 'DESC')->get();
      // return Jadwal::all();
    }
    // dd($guruId, $role, $periode);
  }

  public function store($input)
  {
    $jadwal = Jadwal::updateOrCreate(
      [
        'id' => $input['id'] ?? null,
        'periode_id' => $input['periode_id'],
        'sekolah_id' => $input['sekolah_id'],
        'rombel_id' => $input['rombel_id'],
        'guru_id' => $input['guru_id'],
        'jamke' => $input['jamke'],
        'hari' => $input['hari']
      ],
      [
        'rombel_id' => $input['rombel_id']
      ]
      );
      return $jadwal;
  }
}