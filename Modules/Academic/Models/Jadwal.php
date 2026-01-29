<?php

namespace Modules\Academic\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $fillable = ['kelas_id', 'instruktur_id', 'hari_id', 'jam_mulai', 'jam_selesai', 'ruangan'];

    protected $casts = [
        // Removed time casts as they're not supported in this Laravel version
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class);
    }

    public function hari()
    {
        return $this->belongsTo(Hari::class);
    }
}
