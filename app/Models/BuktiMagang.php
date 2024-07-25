<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiMagang extends Model
{
    use HasFactory;

    protected $table = 'bukti_magangs';
    protected $fillable = [
        'jawaban',
        'nama_file',
        'ajuan_id',
    ];

    public function ajuanmagangs()
    {
        return $this->belongsTo(AjuanMagang::class, 'ajuan_id', 'id');
    }

}

