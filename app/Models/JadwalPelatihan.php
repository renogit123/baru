<?php

namespace App\Models;
use App\Models\RegisterPelatihan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalPelatihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'tgl_mulai', 'tgl_selesai', 'pembiayaan', 'kelas', 'status'
    ];

    public function pendaftars()
    {
        return $this->hasMany(\App\Models\RegisterPelatihan::class, 'jadwal_pelatihan_id');
    }

    public function registers()
{
    return $this->hasMany(RegisterPelatihan::class, 'jadwal_pelatihan_id');
}

}