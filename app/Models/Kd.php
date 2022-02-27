<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kd extends Model
{
    use HasFactory;

    protected $fillable = ['ki', 'kode_kd','tingkat', 'semester', 'teks'];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'tingkat','tingkat');
    }

    public function indikators()
    {
        return $this->hasMany(Indikator::class, 'kd_id', 'kode_kd');
    }
}


