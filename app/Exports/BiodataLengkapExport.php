<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BiodataLengkapExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        $users = User::with('biodata')
            ->whereHas('biodata')
            ->orderBy('name', 'asc')
            ->get();

        $no = 1;

        return $users->map(function ($user) use (&$no) {
            return [
                $no++,
                $user->name,
                $user->biodata->nik,
                $user->biodata->tempat_lahir,
                $user->biodata->tanggal_lahir,
                $user->biodata->jenis_kelamin,
                $user->biodata->agama,
                $user->biodata->status_kawin,
                $user->biodata->jabatan,
                $user->biodata->lama_menjabat,
                $user->biodata->nomor_sk_jabatan,
                $user->biodata->pendidikan,
                $user->biodata->no_telp,
                $user->biodata->alamat,
                $user->biodata->kelurahan,
                $user->biodata->kecamatan,
                $user->biodata->kabupaten,
                $user->biodata->provinsi,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NIK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Status Kawin',
            'Jabatan',
            'Lama Menjabat (th)',
            'Nomor SK Jabatan',
            'Pendidikan',
            'No Telepon',
            'Alamat',
            'Kelurahan',
            'Kecamatan',
            'Kabupaten',
            'Provinsi',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:R1')->getFont()->setBold(true);
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A1:R{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '888888'],
                ],
            ],
            'alignment' => [
                'vertical' => 'center',
                'horizontal' => 'left',
            ],
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Nama
            'C' => 18,  // NIK
            'D' => 20,  // Tempat Lahir
            'E' => 15,  // Tanggal Lahir
            'F' => 12,  // JK
            'G' => 14,  // Agama
            'H' => 16,  // Status Kawin
            'I' => 25,  // Jabatan
            'J' => 10,  // Lama
            'K' => 25,  // SK
            'L' => 18,  // Pendidikan
            'M' => 18,  // No Telp
            'N' => 30,  // Alamat
            'O' => 18,  // Kelurahan
            'P' => 18,  // Kecamatan
            'Q' => 20,  // Kabupaten
            'R' => 20,  // Provinsi
        ];
    }
}
