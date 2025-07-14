<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'id_desa',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'kode_desa',
        'nik',
        'npwp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'status_kawin',
        'jabatan',
        'lama_menjabat',
        'nomor_sk_jabatan',
        'pendidikan',
        'no_telp',
        'is_approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    protected $casts = [
        'is_approved' => 'boolean',
    ];

public function kelurahan()
{
    return $this->belongsTo(Kelurahan::class, 'id_desa');
}


}
