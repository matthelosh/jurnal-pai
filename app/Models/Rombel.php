<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;

    protected $fillable = ['periode_id', 'periode_id','sekolah_id','guru_id','kode_rombel','nama_rombel','tingkat','siswa','siswi', 'active'];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id','kode_periode');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'npsn');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'rombel_id', 'kode_rombel');
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($rombel){
            $rombel->jadwals()->delete();
        });
    }
}
