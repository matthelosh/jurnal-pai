<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = ['npsn', 'nama_sekolah', 'alamat', 'telp', 'email', 'website', 'nama_ks','nip_ks'];

    public function gurus()
    {
        return $this->hasMany(Guru::class, 'sekolah_id', 'npsn');
    }

    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'sekolah_id','npsn');
    }
}
