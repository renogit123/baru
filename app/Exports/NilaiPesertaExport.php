<?php

namespace App\Exports;

use App\Models\JadwalPelatihan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NilaiPesertaExport implements FromArray, WithHeadings
{
    protected $jadwal;

    public function __construct(JadwalPelatihan $jadwal)
    {
        $this->jadwal = $jadwal;
    }

    public function array(): array
    {
        $data = [];
        $no = 1;

        foreach ($this->jadwal->pendaftars as $peserta) {
            if ($peserta->status_peserta !== 'approved') {
                continue;
            }

            $bio = $peserta->user->biodata;
            if (!$bio) continue;

            $jk = strtolower($bio->jenis_kelamin) === 'perempuan' ? 'P' : 'L';

            $data[] = [
                'NO' => $no++,
                'NAMA' => strtoupper($bio->nama),
                'L/P' => $jk,
                'JABATAN' => $bio->jabatan,
                'PRE TEST' => '',
                'POST TEST' => '',
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return ['NO', 'NAMA', 'L/P', 'JABATAN', 'PRE TEST', 'POST TEST'];
    }
}
