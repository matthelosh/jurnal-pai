<?php

namespace App\Services;

use App\Models\Sekolah;

class SekolahService {

  public function index()
  {
      return Sekolah::all();
  }

  public function store($input)
  {
    $store = Sekolah::updateOrCreate(
      [
        'id' => $input['id'] ?? null,
      ],
      [
        'npsn' => $input['npsn'], 
        'nama_sekolah' => $input['nama_sekolah'], 
        'alamat' => $input['alamat'], 
        'telp' => $input['tels'] ?? null, 
        'email' => $input['email'] ?? null, 
        'website' => $input['website'] ?? null, 
        'nama_ks' => $input['nama_ks'],
        'nip_ks' => $input['nip_ks'] ?? null
      ]
    );
  }
}