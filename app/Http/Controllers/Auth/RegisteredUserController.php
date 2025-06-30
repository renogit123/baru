<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Biodata;
use App\Models\Kelurahan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman register
     */
    public function create(): View
    {
        $kelurahans = Kelurahan::with('kecamatan.kabupatenKota.provinsi')->get();
        return view('auth.register', compact('kelurahans'));
    }

    /**
     * Simpan user dan biodata saat registrasi
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Validasi akun
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Validasi biodata
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'id_desa' => 'required|exists:kelurahans,id',
            'nik' => 'required|numeric|unique:biodatas',
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

        // Buat user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Ambil data wilayah
        $desa = Kelurahan::with('kecamatan.kabupatenKota.provinsi')->findOrFail($request->id_desa);

        // Simpan biodata
        Biodata::create([
            'user_id'    => $user->id,
            'nama'       => $request->nama,
            'alamat'     => $request->alamat,
            'id_desa'    => $request->id_desa,
            'provinsi'   => $desa->kecamatan->kabupatenKota->provinsi->nama ?? null,
            'kabupaten'  => $desa->kecamatan->kabupatenKota->nama ?? null,
            'kecamatan'  => $desa->kecamatan->nama ?? null,
            'kelurahan'  => $desa->nama,
            'kode_desa'  => $desa->kode,
            'nik'        => $request->nik,
            'npwp'       => $request->npwp,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama'      => $request->agama,
            'status_kawin' => $request->status_kawin,
            'jabatan'    => $request->jabatan,
            'lama_menjabat' => $request->lama_menjabat,
            'nomor_sk_jabatan' => $request->nomor_sk_jabatan,
            'pendidikan' => $request->pendidikan,
            'no_telp'    => $request->no_telp,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
