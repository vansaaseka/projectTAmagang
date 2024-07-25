<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'prodi_id',
        'email',
        'password',
        'role_id',
        'status',
        'nim',
        'nip',
        'no_wa',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function ajuanmagangs()
    {
        return $this->hasMany(AjuanMagang::class, 'user_id', 'id');
    }

    public function units()
    {
        return $this->belongsTo(Unit::class, 'prodi_id', 'id');
    }
}
