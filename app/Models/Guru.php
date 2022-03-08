<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = ['nip','nama','jk','sekolah_id'];

    public function userable()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function rombels()
    {
        return $this->hasMany(Rombel::class);
    }

    public function jurnals()
    {
        return $this->hasMany(Jurnal::class);
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'npsn');
    }

    public function rpes()
    {
        return $this->hasMany(Rpe::class, 'guru_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($guru) {
            $guru->user()->delete();
            $guru->rombels()->delete();
            $guru->jurnals()->delete();
            $guru->jadwals()->delete();
        });
    }
}
