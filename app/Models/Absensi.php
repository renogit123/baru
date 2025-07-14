<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jadwal_pelatihan_id',
        'tanggal_absen',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalPelatihan()
    {
        return $this->belongsTo(JadwalPelatihan::class);
    }

    public function registerPelatihan()
{
    return $this->belongsTo(RegisterPelatihan::class);
}

}
