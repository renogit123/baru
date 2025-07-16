<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

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

    public function searchDesa(Request $request)
{
    $q = $request->query('q');

    $results = Kelurahan::with(['kecamatan.kabupatenKota.provinsi'])
        ->where('nama', 'like', "%{$q}%")
        ->limit(20)
        ->get()
        ->map(function ($desa) {
            return [
                'id' => $desa->id,
                'nama' => $desa->nama,
                'kecamatan' => $desa->kecamatan->nama ?? '',
                'kabupaten' => $desa->kecamatan->kabupatenKota->nama ?? '',
                'provinsi' => $desa->kecamatan->kabupatenKota->provinsi->nama ?? '',
            ];
        });

    return response()->json($results);
}
}
