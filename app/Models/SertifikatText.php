<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SertifikatText extends Model
{
    protected $fillable = [
        'deskripsi_atas',
        'judul_tengah',
        'deskripsi_bawah',
        'penandatangan',
        'jabatan_penandatangan',
        'nip_penandatangan',
        'tanggal_sertifikat',
        'kota_penetapan',
        'tanggal_penetapan',
        'jabatan_penetapan',
        'nomor_sertifikat',
    ];
}

