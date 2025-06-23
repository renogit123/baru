<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterPelatihan extends Model
{
    protected $fillable = ['user_id', 'jadwal_pelatihan_id', 'status_peserta', 'status_kehadiran'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalPelatihan::class, 'id_jadwal');
    }
}