<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KabupatenKota extends Model
{
    protected $fillable=['provinsi_id','nama','kode'];
public function provinsi(){ return $this->belongsTo(Provinsi::class); }
public function kecamatans(){ return $this->hasMany(Kecamatan::class); }

}
