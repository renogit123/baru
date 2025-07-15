<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterPelatihan;
use App\Models\Absensi;
use Carbon\Carbon;

class ScanAbsenController extends Controller
{
    public function form()
    {
        return view('admin.scan.form');
    }

public function proses(Request $request)
{
    $kode = $request->scan_result;

    $register = RegisterPelatihan::find($kode);
    if (!$register) {
        return back()->with('error', '❌ QR tidak ditemukan atau tidak valid.');
    }

    $today = Carbon::today()->toDateString();

    $sudahAbsen = Absensi::where('register_pelatihan_id', $register->id)
        ->whereDate('tanggal_absen', $today)
        ->exists();

    if ($sudahAbsen) {
        return back()->with('error', '❌ Peserta sudah absen hari ini.');
    }

    // ✅ Simpan absensi baru (kode ini yang kamu tanyakan)
    Absensi::create([
        'register_pelatihan_id' => $register->id,
        'tanggal_absen' => $today,
        'jam' => Carbon::now()->format('H:i:s'),
        'status_kehadiran' => 'hadir',
    ]);

    return back()->with('success', '✅ Kehadiran dicatat untuk ' . ($register->user->biodata->nama ?? 'peserta'));
}


public function daftarHadir(Request $request)
{
    $tanggal = trim($request->input('tanggal')) ?: now()->toDateString();

    $absensis = Absensi::with(['register.user.biodata', 'register.jadwalPelatihan'])
        ->where('status_kehadiran', 'hadir')
        ->whereDate('tanggal_absen', $tanggal)
        ->get();

    $groupedPaginated = [];
    $jadwalIds = [];

    $perPage = 10;

    $grouped = $absensis->groupBy(function ($absen) {
        return $absen->register->jadwalPelatihan->kelas ?? 'Tanpa Kelas';
    });

    foreach ($grouped as $kelas => $group) {
        $searchKey = 'search_' . $kelas;
        $search = $request->input($searchKey);

        $filtered = collect($group)->filter(function ($item) use ($search) {
            if (!$search) return true;

            $biodata = $item->register->user->biodata;
            $nama = strtolower($biodata->nama ?? '');
            $nik = strtolower($biodata->nik ?? '');
            return str_contains($nama, strtolower($search)) || str_contains($nik, strtolower($search));
        });

        $page = $request->get("page_$kelas", 1);
        $paged = $filtered->forPage($page, $perPage);
        $groupedPaginated[$kelas] = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $filtered->count(),
            $perPage,
            $page,
            ['pageName' => "page_$kelas"]
        );

        $jadwalIds[$kelas] = $group->first()->register->jadwalPelatihan->id ?? null;
    }

    return view('admin.scan.hadir', [
        'groupedPaginated' => $groupedPaginated,
        'jadwalIds' => $jadwalIds,
        'tanggal' => $tanggal,
    ]);
}

}
