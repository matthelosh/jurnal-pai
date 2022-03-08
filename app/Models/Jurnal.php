<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $fillable = ['periode_id', 'sekolah_id', 'guru_id','rombel_id', 'kd_id', 'hari', 'tanggal','tema','subtema','absensi_siswa','catatan','teks'];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id','kode_periode');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'npsn');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id', 'kode_rombel');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
