<?php

namespace Modules\Academic\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['kode_kelas', 'nama_kelas', 'deskripsi', 'status', 'kapasitas', 'tahun_akademik', 'instruktur_id'];

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class);
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'kelas_mahasiswa');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function risalah()
    {
        return $this->hasMany(Risalah::class);
    }
}
