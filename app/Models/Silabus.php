<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Silabus extends Model
{
    use HasFactory;
    protected $fillable = ['kelas','semester', 'tapel','pertemuan','kd_id','indikator','pembelajaran_id','proses','media','waktu','penilaian','karakter', 'keterangan'];
}
