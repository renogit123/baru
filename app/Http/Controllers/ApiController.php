<?php

namespace App\Http\Controllers;

use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class ApiController extends Controller
{
    public function getKabupaten($provinsi_id)
    {
        return KabupatenKota::with('provinsi')
            ->where('provinsi_id', $provinsi_id)
            ->get();
    }

    public function getKecamatan($kabupaten_id)
    {
        return Kecamatan::with('kabupatenKota')
            ->where('kabupaten_kota_id', $kabupaten_id)
            ->get();
    }

    public function getKelurahan($kecamatan_id)
    {
        return Kelurahan::with('kecamatan')
            ->where('kecamatan_id', $kecamatan_id)
            ->get();
    }
}
