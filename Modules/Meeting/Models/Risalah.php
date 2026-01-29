<?php

namespace Modules\Meeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risalah extends Model
{
    use HasFactory;

    protected $table = 'risalah';
    protected $fillable = ['judul', 'tanggal', 'peserta', 'isi', 'keputusan', 'follow_up'];

    protected $casts = [
        'tanggal' => 'datetime',
    ];
}
