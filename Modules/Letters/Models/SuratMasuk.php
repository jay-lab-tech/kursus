<?php

namespace Modules\Letters\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Disposition\Models\Disposisi;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';
    protected $fillable = ['nomor_surat', 'tanggal_terima', 'pengirim', 'perihal', 'isi', 'lampiran'];

    protected $casts = [
        'tanggal_terima' => 'datetime',
    ];

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class);
    }
}
