<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class AdminController extends Controller
{
    public function wilayah(Request $request)
    {
        $provinsis = Provinsi::when($request->search_provinsi, function ($query) use ($request) {
            $query->where('nama', 'like', '%' . $request->search_provinsi . '%');
        })->orderBy('nama')->paginate(100, ['*'], 'provinsis');

        $kabupatens = KabupatenKota::with('provinsi')
            ->when($request->search_kabupaten_kota, function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search_kabupaten_kota . '%');
            })
            ->orderBy('nama')->paginate(100, ['*'], 'kabupatens');

        $kecamatans = Kecamatan::with('kabupatenKota')
            ->when($request->search_kecamatan, function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search_kecamatan . '%');
            })
            ->orderBy('nama')->paginate(100, ['*'], 'kecamatans');

        $kelurahans = Kelurahan::with('kecamatan')
            ->when($request->search_kelurahan, function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->search_kelurahan . '%');
            })
            ->orderBy('nama')->paginate(100, ['*'], 'kelurahans');

        // data untuk pilihan dropdown (tanpa pagination)
        $provinsisAll = Provinsi::orderBy('nama')->get();
        $kabupatensAll = KabupatenKota::orderBy('nama')->get();
        $kecamatansAll = Kecamatan::orderBy('nama')->get();

        return view('admin.wilayah', [
            'provinsis' => $provinsis,
            'kabupatens' => $kabupatens,
            'kecamatans' => $kecamatans,
            'kelurahans' => $kelurahans,

            'provinsisAll' => $provinsisAll,
            'kabupatensAll' => $kabupatensAll,
            'kecamatansAll' => $kecamatansAll,

            'editProvinsi' => $request->edit_provinsi ? Provinsi::find($request->edit_provinsi) : null,
            'editKabupaten' => $request->edit_kabupaten_kota ? KabupatenKota::find($request->edit_kabupaten_kota) : null,
            'editKecamatan' => $request->edit_kecamatan ? Kecamatan::find($request->edit_kecamatan) : null,
            'editKelurahan' => $request->edit_kelurahan ? Kelurahan::find($request->edit_kelurahan) : null,
        ]);
    }

    public function index()
    {
        return view('admin.dashboard');
    }
}
