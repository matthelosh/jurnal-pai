<?php

namespace App\Services;

use Faker\Factory;
use App\Models\Guru;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Support\Facades\Hash;


class GuruService
{
  
  public function index()
  {
    return Guru::with('sekolah','userable')->get();
  }

  public function store($input)
  {
    // $faker = new Base;
    $guru = Guru::updateOrCreate(
      [
        'id' => $input['id'] ?? null
      ],
      [
        'nip' => $input['nip'] ?? Base::numerify('##################'),
        'nama' => $input['nama'],
        'jk' => $input['jk'],
        'sekolah_id' => $input['sekolah_id']
      ]
    );

    return $guru;
  }

  public function createAccount($gurus)
  {
    $res = [];
    foreach($gurus as $guru)
    {
      $nama = explode(' ', $guru['nama']);
      $create = User::updateOrCreate(
        [
          'userid' => $guru['nip'] ?? Base::numerify('##################'),
          'username' => str_replace('.','',strtolower($nama[0].'_'.($nama[1]??''))),
        ],
        [
          'email' => str_replace('.','',strtolower($nama[0].'_'.($nama[1]??''))).'@kkgpaiwagir.or.id',
          'password' => Hash::make('12345'),
          'role' => 'guru',
          'hp' => '0',
          'userable_id' => $guru['id'],
          'userable_type' => 'App\Models\Guru'
        ]
      );
      array_push($res, $create);
    }

    return $res;
  }

  public function impor($gurus)
  {
    $res = [];
    foreach($gurus as $guru)
    {
      $guru = Guru::updateOrCreate(
        [
          'id' => $guru['id'] ?? null
        ],
        [
          'nip' => $guru['nip'] ?? Base::numerify('##################'),
          'nama' => $guru['nama'],
          'jk' => $guru['jk'],
          'sekolah_id' => $guru['sekolah_id'] ?? null
        ]
      );
      array_push($res, $guru);
    }

    return $res;
  }

  public function destroy($id)
  {
    return Guru::find($id)->delete();
  }

  public function destroySome($datas)
  {
    $ids = [];
    foreach($datas as $data)
    {
      array_push($ids, $data['id']);
    }

    $hapus = Guru::destroy($ids);
    return($hapus);
  }

}
