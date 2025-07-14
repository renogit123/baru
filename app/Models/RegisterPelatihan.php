<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterPelatihan extends Model
{
    protected $fillable = ['user_id', 'jadwal_pelatihan_id', 'status_peserta', 'status_kehadiran'];

public function user()
{
    return $this->belongsTo(User::class);
}

    public function jadwal()
    {
        return $this->belongsTo(JadwalPelatihan::class, 'id_jadwal');
    }

    public function jadwalPelatihan()
{
    return $this->belongsTo(\App\Models\JadwalPelatihan::class, 'jadwal_pelatihan_id');
}
public function absensis()
{
    return $this->hasMany(Absensi::class, 'register_pelatihan_id');
}

}