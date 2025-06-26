<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biodata;
use App\Models\Kelurahan;
use Illuminate\Support\Facades\Auth;

class BiodataController extends Controller
{
    public function form()
    {
        $kelurahans = Kelurahan::with('kecamatan.kabupatenKota.provinsi')->get();

        // Ambil biodata user jika sudah ada
        $biodata = Biodata::where('user_id', Auth::id())->first();

        return view('user.biodata.form', compact('kelurahans', 'biodata'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'id_desa' => 'required|exists:kelurahans,id',
            'nik' => 'required|numeric',
            'npwp' => 'nullable|string|max:25',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string',
            'status_kawin' => 'required|string',
            'jabatan' => 'required|string',
            'lama_menjabat' => 'required|integer',
            'nomor_sk_jabatan' => 'required|string|max:50',
            'pendidikan' => 'required|string',
            'no_telp' => 'required|string|max:20',
        ]);

        // Ambil relasi wilayah berdasarkan id_desa
        $desa = Kelurahan::with('kecamatan.kabupatenKota.provinsi')->findOrFail($request->id_desa);

        // Simpan atau update biodata user
        Biodata::updateOrCreate(
            ['user_id' => Auth::id()],
            array_merge($validated, [
                'user_id'    => Auth::id(),
                'provinsi'   => $desa->kecamatan->kabupatenKota->provinsi->nama ?? null,
                'kabupaten'  => $desa->kecamatan->kabupatenKota->nama ?? null,
                'kecamatan'  => $desa->kecamatan->nama ?? null,
                'kelurahan'  => $desa->nama,
                'kode_desa'  => $desa->kode,
            ])
        );

        return redirect()->route('user.biodata.form')->with('success', 'Biodata berhasil disimpan!');
    }
}
