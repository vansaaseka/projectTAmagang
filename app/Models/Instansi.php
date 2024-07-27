<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_instansi',
        'kategori_instansi_id',
        'no_telpon',
        'alamat_surat',
        'alamat_instansi',
        'user_id'
    ];

    public function kategoriInstansi()
    {
        return $this->belongsTo(KategoriInstansi::class, 'kategori_instansi_id');
    }

    public function ajuanmagangs()
    {
        return $this->hasMany(AjuanMagang::class, 'instansi_id');
    }
}
