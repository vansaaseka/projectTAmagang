<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaranSemester extends Model
{
    use HasFactory;

    protected $fillable =[
        'nama_tahun',
        'tahun'
    ];

    public function ajuanmagangs() {
        return $this->hasMany(AjuanMagang::class, 'tahun_ajaran_id');
    }
}
