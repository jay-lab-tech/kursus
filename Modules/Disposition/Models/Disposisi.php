<?php

namespace Modules\Disposition\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Letters\Models\SuratMasuk;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';
    protected $fillable = ['surat_masuk_id', 'user_id', 'catatan', 'status', 'tanggal_disposisi'];

    protected $casts = [
        'tanggal_disposisi' => 'datetime',
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
