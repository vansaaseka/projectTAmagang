<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriInstansi extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];

    public function instansis()
    {
        return $this->hasMany(Instansi::class, 'kategori_instansi_id');
    }
}
