<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $fillable = ['nama', 'kode'];

    public function kabupatenKotas()
    {
        return $this->hasMany(KabupatenKota::class);
    }
}

