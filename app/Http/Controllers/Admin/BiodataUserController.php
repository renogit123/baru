<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use App\Exports\BiodataLengkapExport;
use Maatwebsite\Excel\Facades\Excel;

class BiodataUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('biodata')
            ->whereHas('biodata')
            ->orderBy('name', 'asc'); // urut abjad

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('biodata', function ($sub) use ($search) {
                      $sub->where('nik', 'like', "%{$search}%")
                          ->orWhere('jabatan', 'like', "%{$search}%");
                  });
            });
        }

        $users = $query->paginate(7)->appends(['search' => $search]);

        return view('admin.biodata.index', compact('users', 'search'));
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
            'nik' => 'required|digits:16',
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

    public function exportExcelBiodata()
    {
        return Excel::download(new BiodataLengkapExport, 'biodata-peserta.xlsx');
    }
}
