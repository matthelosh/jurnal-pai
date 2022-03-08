<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ki extends Model
{
    use HasFactory;

    protected $fillable = ['tingkat', 'kode_ki', 'teks', 'mode'];

    public function kds()
    {
        return $this->hasMany(Kd::class, 'ki','kode_ki');
    }

}
