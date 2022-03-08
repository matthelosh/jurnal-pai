<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kaldik extends Model
{
    use HasFactory;
    protected $fillable = ['guru_id', 'tapel', 'name','start','end','location','detail','isEfektif', 'color'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id','id');
    }
}
