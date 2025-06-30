<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SertifikatText;

class SertifikatTextController extends Controller
{
    public function edit()
    {
        $text = SertifikatText::firstOrCreate([]); // Jika belum ada, buat default
        return view('admin.sertifikat.edit', compact('text'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'deskripsi_atas' => 'nullable|string',
            'judul_tengah' => 'nullable|string',
            'deskripsi_bawah' => 'nullable|string',
            'nomor_sertifikat' => 'nullable|string',
            'penandatangan' => 'nullable|string',
            'jabatan_penandatangan' => 'nullable|string',
            'nip_penandatangan' => 'nullable|string',
            'tanggal_sertifikat' => 'nullable|date',
            'kota_penetapan' => 'nullable|string',
            'tanggal_penetapan' => 'nullable|date',
            'jabatan_penetapan' => 'nullable|string',
        ]);

        SertifikatText::updateOrCreate(['id' => 1], $validated);

        return redirect()->route('admin.sertifikat.edit')->with('success', 'Teks sertifikat berhasil disimpan.');
    }
}
