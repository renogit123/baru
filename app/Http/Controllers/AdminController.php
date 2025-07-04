<?php

    namespace App\Http\Controllers;

    use App\Models\Biodata;
    use App\Models\JadwalPelatihan;
    use App\Models\User;
    use Illuminate\Http\Request;
    use App\Models\Provinsi;
    use App\Models\KabupatenKota;
    use App\Models\Kecamatan;
    use App\Models\Kelurahan;

    class AdminController extends Controller
    {
        public function index()
{
    return $this->dashboard();
}


        public function wilayah(Request $request)
        {
            $searchProvinsi = $request->input('search_provinsi');
            $searchKabupaten = $request->input('search_kabupaten_kota');
            $searchKecamatan = $request->input('search_kecamatan');
            $searchKelurahan = $request->input('search_kelurahan');

            return view('admin.wilayah', [
                // ================== PROVINSI ==================
                'provinsis' => Provinsi::when($searchProvinsi, function ($query, $search) {
                        return $query->where('nama', 'like', "%{$search}%")
                                    ->orWhere('kode', 'like', "%{$search}%");
                    })
                    ->orderBy('nama')
                    ->paginate(10, ['*'], 'provinsis')
                    ->appends(['search_provinsi' => $searchProvinsi]),

                // ================== KABUPATEN/KOTA ==================
                'kabupatens' => KabupatenKota::with('provinsi')
                    ->when($searchKabupaten, function ($query, $search) {
                        return $query->where('nama', 'like', "%{$search}%")
                                    ->orWhere('kode', 'like', "%{$search}%");
                    })
                    ->orderBy('nama')
                    ->paginate(10, ['*'], 'kabupatens')
                    ->appends(['search_kabupaten_kota' => $searchKabupaten]),

                // ================== KECAMATAN ==================
                'kecamatans' => Kecamatan::with('kabupatenKota')
                    ->when($searchKecamatan, function ($query, $search) {
                        return $query->where('nama', 'like', "%{$search}%")
                                    ->orWhere('kode', 'like', "%{$search}%");
                    })
                    ->orderBy('nama')
                    ->paginate(10, ['*'], 'kecamatans')
                    ->appends(['search_kecamatan' => $searchKecamatan]),

                // ================== KELURAHAN ==================
                'kelurahans' => Kelurahan::with('kecamatan.kabupatenKota.provinsi')
                    ->when($searchKelurahan, function ($query, $search) {
                        return $query->where('nama', 'like', "%{$search}%")
                                    ->orWhere('kode', 'like', "%{$search}%");
                    })
                    ->orderBy('nama')
                    ->paginate(10, ['*'], 'kelurahans')
                    ->appends(['search_kelurahan' => $searchKelurahan]),

                // ================== DATA EDIT ==================
                'editProvinsi' => $request->edit_provinsi ? Provinsi::find($request->edit_provinsi) : null,
                'editKabupaten' => $request->edit_kabupaten_kota ? KabupatenKota::find($request->edit_kabupaten_kota) : null,
                'editKecamatan' => $request->edit_kecamatan ? Kecamatan::find($request->edit_kecamatan) : null,
                'editKelurahan' => $request->edit_kelurahan ? Kelurahan::find($request->edit_kelurahan) : null,
            ]);
        }

        public function dashboard()
        {
            return view('admin.dashboard', [
                'jumlahUser' => User::count(),
                'jumlahBiodata' => Biodata::count(),
                'jumlahPelatihan' => JadwalPelatihan::count(),
            ]);
        }
    }