<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $fillable = ['kode_periode', 'label','tapel', 'semester','active'];

    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'periode_id', 'kode_periode');
    }

    public function jurnals()
    {
        return $this->hasMany(Jurnal::class, 'periode_id', 'kode_periode');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'periode_id','kode_periode');
    }
}
