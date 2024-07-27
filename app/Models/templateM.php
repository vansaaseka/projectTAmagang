<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class templateM extends Model
{
    use HasFactory;
    protected $table = 'template';
    protected $fillable = ['namatemplate', 'template'];
    protected $guarded = [];

}
