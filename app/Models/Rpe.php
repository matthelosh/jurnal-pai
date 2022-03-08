<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rpe extends Model
{
    use HasFactory;
    protected  $fillable = ['guru_id','tapel','bulan', 'hari', 'tanggals'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id');
    }
}
