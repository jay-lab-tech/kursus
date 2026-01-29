<?php

namespace Modules\Academic\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Risalah extends Model
{
    use HasFactory;

    protected $table = 'risalah';

    protected $fillable = [
        'kelas_id',
        'instruktur_id',
        'tanggal',
        'judul',
        'isi',
        'catatan_penting',
        'peserta_hadir',
        'file',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'peserta_hadir' => 'integer',
    ];

    /**
     * Relationship: Risalah belongs to Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Relationship: Risalah belongs to Instruktur
     */
    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class);
    }
}
