<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelatihanBaru extends Model
{
    protected $table = 'jadwal_pelatihan_baru';

    protected $fillable = ['judul'];
}
