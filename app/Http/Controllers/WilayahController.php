<?php

namespace App\Http\Controllers;

use App\Models\{Provinsi, KabupatenKota, Kecamatan, Kelurahan};

class WilayahController extends Controller
{
    public function getKabupaten($provinsi_id)
    {
        return KabupatenKota::where('provinsi_id', $provinsi_id)->get();
    }

    public function getKecamatan($kabupaten_id)
    {
        return Kecamatan::where('kabupaten_kota_id', $kabupaten_id)->get();
    }

    public function getKelurahan($kecamatan_id)
    {
        return Kelurahan::where('kecamatan_id', $kecamatan_id)->get(['id', 'nama', 'kode_desa']);
    }
}
