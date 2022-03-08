<?php

namespace App\Models;

use App\Models\Kd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prota extends Model
{
    use HasFactory;

    protected $fillabel = ['tingkat','semester', 'pelajaran','ki','kd','materi','alokasi_waktu','mode'];

}
