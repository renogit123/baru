<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelurahan;
use App\Models\Biodata;
use Illuminate\Http\Request;

class BiodataUserController extends Controller
{
    public function index()
    {
        $users = User::with('biodata')->get();
        return view('admin.biodata.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::with('biodata')->findOrFail($id);
        $kelurahans = Kelurahan::with('kecamatan.kabupatenKota.provinsi')->get();

        return view('admin.biodata.edit', [
            'user' => $user,
            'biodata' => $user->biodata,
            'kelurahans' => $kelurahans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'id_desa' => 'required|exists:kelurahans,id',
            'nik' => 'required|numeric',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_kawin' => 'required|in:Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
            'jabatan' => 'required|string',
            'lama_menjabat' => 'required|numeric',
            'nomor_sk_jabatan' => 'required|string|max:255',
            'pendidikan' => 'required|string',
            'no_telp' => 'required|string|max:20',
        ]);
    
        $user = User::findOrFail($id);
    
        // Ambil data wilayah lengkap
        $desa = Kelurahan::with('kecamatan.kabupatenKota.provinsi')->findOrFail($request->id_desa);
    
        $user->biodata()->updateOrCreate(
            ['user_id' => $user->id],
            $validated + [
                'id_desa'   => $request->id_desa,
                'provinsi'  => $desa->kecamatan->kabupatenKota->provinsi->nama ?? null,
                'kabupaten' => $desa->kecamatan->kabupatenKota->nama ?? null,
                'kecamatan' => $desa->kecamatan->nama ?? null,
                'kelurahan' => $desa->nama,
                'kode_desa' => $desa->kode,
            ]
        );
    
        return redirect()->route('admin.user.biodata.index')->with('success', 'Biodata berhasil diperbarui.');
    }
    
    public function destroy($id)
{
    $user = User::findOrFail($id);

    if ($user->biodata) {
        $user->biodata->delete();
    }

    return redirect()->back()->with('success', 'Biodata berhasil dihapus.');
}
}
