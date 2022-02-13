<?php

namespace App\Services;

use App\Models\Rombel;

class RombelService {
 
  public function index($idGuru = null)
  {
    if (!$idGuru) {
      return Rombel::where('active',1)->get();
    } else {
      return Rombel::where(['active' => 1, 'guru_id' => $idGuru])->get();
    }
  }

  public function store($input)
  {
    $rombel = Rombel::updateOrCreate(
      [
        'id' => $input['id'] ?? null,
        
      ],
      [
        'kode_rombel' => $input['kode_rombel'],
        'tingkat' => $input['tingkat'],
        'nama_rombel' => $input['nama_rombel'],
        'guru_id' => $input['guru_id'],
        'periode_id' => $input['periode_id'],
        'sekolah_id' => $input['sekolah_id'],
        'siswa' => $input['siswa'],
        'siswi' => $input['siswi']
      ]
      );
    return $rombel;
  }

  public function destroy($id)
  {
    $rombel = Rombel::find($id)->delete();
    return $rombel;
  }
}