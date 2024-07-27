<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   AjuanMagang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instansi_id',
        'bukti_magang_id',
        'anggota_id',
        'proposal_id',
        'laporan_akhir',
        'angkatan',
        'surat_pengantar',
        'surat_tugas',
        'jenis_ajuan',
        'status',
        'bobot_sks',
        'file_nilai',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis_kegiatan',
        'dosen_pembimbing',
        'semester',
        'tahun',
        'verified',
        'surat_selesai'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function proposals()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id');
    }

    public function anggotas()
    {
        return $this->belongsToMany(Anggota::class, 'kelompoks', );
    }

    public function instansis()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id', 'id');
    }

    public function buktimagangs()
    {
        return $this->hasOne(BuktiMagang::class, 'ajuan_id', 'id');
    }

    public function dosenPembimbing()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing', 'id');
    }

}
