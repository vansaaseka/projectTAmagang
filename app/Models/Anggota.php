<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nim'
    ];


    public function ajuanmagangs()
    {
        return $this->belongsToMany(Ajuanmagang::class, 'kelompok', 'id_anggota', 'id_ajuan_magang');
    }

}
