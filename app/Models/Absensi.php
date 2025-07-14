<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'register_pelatihan_id',
        'tanggal_absen',
        'jam',
        'status_kehadiran',
    ];

    public function register()
    {
        return $this->belongsTo(RegisterPelatihan::class, 'register_pelatihan_id');
    }

    // Optional: jika masih ingin relasi lain
    public function user()
    {
        return $this->register?->user(); // relasi tidak langsung
    }

    public function jadwalPelatihan()
    {
        return $this->register?->jadwalPelatihan(); // relasi tidak langsung
    }
}
