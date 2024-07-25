<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_file',
        'judul_proposal',
        'status'
    ];

    public function ajuanmagangs()
    {
        return $this->hasOne(AjuanMagang::class, 'proposal_id');
    }
}
