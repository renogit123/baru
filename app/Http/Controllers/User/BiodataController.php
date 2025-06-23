<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use App\Models\Biodata;
use Illuminate\Support\Facades\Auth;

class BiodataController extends Controller
{
    // Tampilkan form biodata
    public function form()
{
    $user = Auth::user();
    $biodata = $user->biodata;
    $kelurahans = Kelurahan::all(); // ambil semua data desa/kelurahan

    return view('user.biodata.form', compact('biodata', 'kelurahans'));
}

    // Simpan atau update data biodata
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'id_desa' => ['required', 'exists:kelurahans,id'],
            'nik' => ['required', 'numeric'],
            'npwp' => ['nullable', 'string', 'max:25'],
            'tempat_lahir' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'agama' => ['required', 'in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu'],
            'status_kawin' => ['required', 'in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati'],
            'jabatan' => ['required', 'string'],
            'lama_menjabat' => ['required', 'integer'],
            'nomor_sk_jabatan' => ['required', 'string', 'max:50'],
            'pendidikan' => ['required', 'string'],
            'no_telp' => ['required', 'string', 'max:20'],
        ]);

        Biodata::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated + ['user_id' => Auth::id()]
        );

        return redirect()->back()->with('success', 'Biodata berhasil disimpan!');
    }
}
