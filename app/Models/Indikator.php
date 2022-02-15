<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    use HasFactory;
    protected $fillable = ['tingkat','kd_id','kode_indikator','teks'];

    public function kd()
    {
        return $this->belongsTo(Kd::class,'kd_id','kode_kd');
    }
}
