<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prosem extends Model
{
    use HasFactory;

    protected $fillable = ['sekolah_id', 'guru_id', 'periode', 'hari', 'rombel_id','pelajaran','kds','bulan','minggu'];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id', 'kode_rombel');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id','id');
    }
}
