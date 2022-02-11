<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $fillable = ['periode_id','sekolah_id', 'rombel_id', 'guru_id','hari','jamke','jml_jam', 'active'];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id','kode_periode');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'npsn');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
