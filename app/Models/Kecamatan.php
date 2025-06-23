<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $fillable=['kabupaten_kota_id','nama','kode'];
public function kabupatenKota(){ return $this->belongsTo(KabupatenKota::class); }
public function kelurahans(){ return $this->hasMany(Kelurahan::class); }

}
