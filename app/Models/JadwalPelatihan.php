<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RegisterPelatihan;
use App\Models\KabupatenKota;
use App\Models\Provinsi;

class JadwalPelatihan extends Model
{
    use HasFactory;

protected $fillable = [
    'judul',
    'tgl_mulai',
    'tgl_selesai',
    'pembiayaan',
    'kelas',
    'status',
    'provinsi_id',
    'kabupaten_id',
];

public function pendaftars()
{
    return $this->hasMany(RegisterPelatihan::class, 'jadwal_pelatihan_id');
}

    public function registers()
    {
        return $this->hasMany(RegisterPelatihan::class, 'jadwal_pelatihan_id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kabupatenKota()
    {
        return $this->belongsTo(KabupatenKota::class, 'kabupaten_id');
    }
}
