<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $fillable = ['nama', 'kode', 'kecamatan_id'];

    protected $appends = ['kode_desa']; // ini penting

    public function getKodeDesaAttribute()
    {
        return $this->attributes['kode'];
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function create()
{
    $kelurahans = Kelurahan::with('kecamatan.kabupatenKota.provinsi')->get();

    return view('auth.register', compact('kelurahans'));
}
}

