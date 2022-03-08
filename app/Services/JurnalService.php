<?php

namespace App\Services;

use App\Models\Jurnal;

class JurnalService {


  public function index($guruId, $periode)
  {
    $jurnals = Jurnal::where([
      ['guru_id','=',$guruId],
      ['periode_id','=', $periode]
    ])->get();

    return $jurnals;
  }

  public function store($input)
  {
    $jurnal = Jurnal::updateOrCreate(
      [
        'id' => $input['id'] ?? null,
      ],
      [
        'periode_id' => $input['periode_id'], 
        'sekolah_id' => $input['sekolah_id'],
        'guru_id' => $input['guru_id'],
        'rombel_id' => $input['rombel_id'], 
        'kd_id' => implode(',', $input['kd_id']), 
        'hari' => $input['hari'], 
        'tanggal' => $input['tanggal'],
        'tema' => $input['tema']['ke'].'. '.$input['tema']['judul'],
        'subtema' => implode(',', $input['subtema']),
        'absensi_siswa' => $input['absensi_siswa'],
        'catatan' => $input['catatan'],
        'teks' => $input['teks'] ?? null
      ]
      );

      return $jurnal;
  }


}