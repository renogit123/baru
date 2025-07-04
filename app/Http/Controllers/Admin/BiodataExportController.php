<?php

namespace App\Http\Controllers\Admin;
use App\Exports\PesertaPelatihanPerJadwalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\JadwalPelatihan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Str;
use FPDF;



require_once base_path('vendor/setasign/fpdf/fpdf.php');

class BiodataExportController extends Controller
{
public function exportKosong()
{
    $users = User::with('biodata')->get();

    $pdf = new \FPDF('L', 'mm', 'A4'); // Landscape
    $pdf->AddPage();

    // Logo kiri atas
    $logoPath = public_path('img/logo-kemendagri.png');
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 19, 5, 20);
    }

    // Header tulisan
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(40, 10);
    $pdf->Cell(0, 5, 'KEMENTERIAN DALAM NEGERI REPUBLIK INDONESIA', 0, 1, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetX(40);
    $pdf->Cell(0, 5, 'BALAI BESAR PEMERINTAHAN DESA DI MALANG', 0, 1, 'L');

    $pdf->Ln(10);

    // Judul Tengah
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 8, 'DAFTAR NILAI PRE TEST DAN POST TEST', 0, 1, 'C');
    $pdf->Cell(0, 8, 'PELATIHAN TEKNIS PENYUSUNAN LAPORAN PENYELENGGARAAN PEMERINTAHAN DESA TAHUN 2024', 0, 1, 'C');
    $pdf->Cell(0, 8, 'KABUPATEN HALMAHERA TENGAH PROVINSI MALUKU UTARA', 0, 1, 'C');
    $pdf->Ln(4);

    // Tanggal
    $tanggal = Carbon::now()->translatedFormat('d F Y');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 2, 'Tanggal, ' . $tanggal, 0, 1, 'L');
    $pdf->Ln(2);

    // Header tabel baris 1
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(10, 14, 'NO', 1, 0, 'C');
    $pdf->Cell(60, 14, 'NAMA', 1, 0, 'C');
    $pdf->Cell(15, 14, 'L/P', 1, 0, 'C');
    $pdf->Cell(100, 14, 'JABATAN', 1, 0, 'C');

    // Merge kolom untuk "NILAI"
    $xNilai = $pdf->GetX();
    $yNilai = $pdf->GetY();
    $pdf->Cell(60, 7, 'N I L A I', 1, 1, 'C');

    // Subheader nilai (PRE TEST dan POST TEST)
    $pdf->SetXY($xNilai, $yNilai + 7);
    $pdf->Cell(30, 7, 'PRE TEST', 1, 0, 'C');
    $pdf->Cell(30, 7, 'POST TEST', 1, 1, 'C');

    // Isi Data
    $pdf->SetFont('Arial', '', 11);
    $no = 1;

    foreach ($users as $user) {
        if (!$user->biodata) continue;

        $jk = strtolower($user->biodata->jenis_kelamin) === 'perempuan' ? 'P' : 'L';

        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(60, 10, strtoupper($user->biodata->nama), 1, 0);
        $pdf->Cell(15, 10, $jk, 1, 0, 'C');
        $pdf->Cell(100, 10, $user->biodata->jabatan, 1, 0);
        $pdf->Cell(30, 10, '', 1, 0); // Kosong Pre Test
        $pdf->Cell(30, 10, '', 1, 1); // Kosong Post Test
    }

    // Tambah rata-rata
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(185, 10, 'RATA-RATA', 1, 0, 'C');
    $pdf->Cell(30, 10, '', 1, 0); // rata-rata pre
    $pdf->Cell(30, 10, '', 1, 1); // rata-rata post

    // Kategori
    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, 'KATEGORI PENILAIAN', 0, 1);
    $pdf->Cell(0, 6, '81 - 100  :  Sangat Baik', 0, 1);
    $pdf->Cell(0, 6, '71 - 80    :  Baik', 0, 1);
    $pdf->Cell(0, 6, '56 - 70    :  Cukup', 0, 1);
    $pdf->Cell(0, 6, '< 56        :  Kurang', 0, 1);

    return response()->streamDownload(function () use ($pdf) {
        $pdf->Output();
    }, 'daftar-nilai-kosong.pdf');
}


public function exportByJadwal($id)
{
    $jadwal = JadwalPelatihan::with(['kabupatenkota', 'provinsi', 'pendaftars.user.biodata'])->findOrFail($id);
    $pdf = new CustomPDF('L', 'mm', 'A4');
    $pdf->AddPage();

    // Logo dan header
    $logoPath = public_path('img/logo-kemendagri.png');
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 19, 5, 20);
    }
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(40, 10);
    $pdf->Cell(0, 5, 'KEMENTERIAN DALAM NEGERI REPUBLIK INDONESIA', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetX(40);
    $pdf->Cell(0, 5, 'BALAI BESAR PEMERINTAHAN DESA DI MALANG', 0, 1, 'L');

    // Judul utama
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 8, 'DAFTAR HADIR', 0, 1, 'C');

    // Tambahan baris judul pelatihan
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->MultiCell(0, 8, strtoupper($jadwal->judul), 0, 'C');

    // Tambahan baris kabupaten/provinsi sesuai logika
    $namaKabupaten = strtoupper($jadwal->kabupatenkota->nama ?? '-');
    $provinsi = strtoupper($jadwal->provinsi->nama ?? '-');

    if (Str::startsWith(strtolower($namaKabupaten), 'kota')) {
        $labelWilayah = $namaKabupaten;
    } else {
        $labelWilayah = 'KABUPATEN ' . $namaKabupaten;
    }

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 8, $labelWilayah . ' PROVINSI ' . $provinsi, 0, 1, 'C');

    // Detail pelatihan
    $tanggal = \Carbon\Carbon::parse($jadwal->tgl_mulai)->translatedFormat('l, d F Y');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 7, 'HARI / TANGGAL           : ' . $tanggal, 0, 1, 'L');
    $pdf->Cell(0, 7, 'WAKTU                           :', 0, 1, 'L');
    $pdf->Cell(0, 7, 'MATERI                          : ' . strtoupper($jadwal->judul), 0, 1, 'L');
    $pdf->Cell(0, 7, 'TENAGA PENGAJAR    :', 0, 1, 'L');

    $pdf->Ln(4);

    // Header tabel
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(10, 14, 'NO', 1, 0, 'C');
    $pdf->Cell(80, 14, 'NAMA LENGKAP', 1, 0, 'C');
    $pdf->Cell(15, 14, 'L / P', 1, 0, 'C');
    $pdf->Cell(110, 14, 'JABATAN DAN ASAL PESERTA', 1, 0, 'C');
    $pdf->Cell(50, 14, 'TANDA TANGAN', 1, 1, 'C');

    // Data peserta
    $pdf->SetFont('Arial', '', 11);
    $no = 1;
    foreach ($jadwal->pendaftars as $peserta) {
        if ($peserta->status_peserta !== 'approved') continue;
        $bio = $peserta->user->biodata;
        if (!$bio) continue;

        $nama = strtoupper($bio->nama);
        $jk = strtolower($bio->jenis_kelamin) === 'perempuan' ? 'P' : 'L';
        $jabatan = $bio->jabatan ?? '-';
        $asal = $bio->alamat ?? '-';
        $textJabatanAsal = $jabatan . ' - ' . $asal;

        $cellNo = 10;
        $cellNama = 80;
        $cellJk = 15;
        $cellAsal = 110;
        $cellTtd = 50;

        $lineCount = max(
            $pdf->NbLines($cellNama, $nama),
            $pdf->NbLines($cellAsal, $textJabatanAsal)
        );
        $rowHeight = $lineCount * 9;
        $xStart = $pdf->GetX();
        $yStart = $pdf->GetY();

        // NO
        $pdf->Cell($cellNo, $rowHeight, $no++, 1, 0, 'C');

        // NAMA
        $pdf->SetXY($xStart + $cellNo, $yStart);
        $pdf->MultiCell($cellNama, 6, $nama, 0, 'L');
        $pdf->Rect($xStart + $cellNo, $yStart, $cellNama, $rowHeight);

        // JENIS KELAMIN
        $pdf->SetXY($xStart + $cellNo + $cellNama, $yStart);
        $pdf->Cell($cellJk, $rowHeight, $jk, 1, 0, 'C');

        // JABATAN DAN ASAL
        $pdf->SetXY($xStart + $cellNo + $cellNama + $cellJk, $yStart);
        $pdf->MultiCell($cellAsal, 6, $textJabatanAsal, 0, 'L');
        $pdf->Rect($xStart + $cellNo + $cellNama + $cellJk, $yStart, $cellAsal, $rowHeight);

        // TANDA TANGAN
        $pdf->SetXY($xStart + $cellNo + $cellNama + $cellJk + $cellAsal, $yStart);
        $pdf->Cell($cellTtd, $rowHeight, '', 1, 1);
    }

    // TTD Ketua Kelas
    $pdf->Ln(20);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 6, '       KETUA KELAS,', 0, 1, 'L');
    $pdf->Ln(15);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 6, '(....................................)', 0, 1, 'L');

    return response()->streamDownload(function () use ($pdf) {
        $pdf->Output();
    }, 'daftar-hadir-pelatihan-' . $id . '.pdf');
}



public function exportExcelByJadwal($id)
{
    $jadwal = JadwalPelatihan::with(['pendaftars.user.biodata', 'provinsi', 'kabupatenkota'])->findOrFail($id);
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $logoPath = public_path('img/logo-kemendagri.png');
    if (file_exists($logoPath)) {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath($logoPath);
        $drawing->setCoordinates('A1');
        $drawing->setHeight(80);
        $drawing->setOffsetX(10);
        $drawing->setWorksheet($sheet);
    }

    $sheet->mergeCells('B1:F1');
    $sheet->mergeCells('B2:F2');
    $sheet->setCellValue('B1', 'KEMENTERIAN DALAM NEGERI REPUBLIK INDONESIA');
    $sheet->setCellValue('B2', 'BALAI BESAR PEMERINTAHAN DESA DI MALANG');
    $sheet->getStyle('B1:B2')->getFont()->setBold(true);
    $sheet->getStyle('B1:B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

    $sheet->mergeCells('A4:F4');
    $sheet->mergeCells('A5:F5');
    $sheet->mergeCells('A6:F6');

    $sheet->setCellValue('A4', 'DAFTAR NILAI PRE TEST DAN POST TEST');
    $sheet->setCellValue('A5', strtoupper($jadwal->judul));

    $kabupatenkotaNama = strtoupper($jadwal->kabupatenkota->nama ?? '');
    $provinsiNama = strtoupper($jadwal->provinsi->nama ?? '');

    if (Str::startsWith($kabupatenkotaNama, 'KOTA')) {
        $wilayahLine = "{$kabupatenkotaNama} PROVINSI {$provinsiNama}";
    } else {
        $wilayahLine = "KABUPATEN {$kabupatenkotaNama} PROVINSI {$provinsiNama}";
    }

    $sheet->setCellValue('A6', $wilayahLine);

    $sheet->getStyle('A4:A6')->getFont()->setBold(true)->setSize(13);
    $sheet->getStyle('A4:A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('A8', 'Tanggal, ' . Carbon::now()->translatedFormat('d F Y'));
    $sheet->getStyle('A8')->getFont()->setSize(10);

    $sheet->setCellValue('A10', 'NO');
    $sheet->setCellValue('B10', 'NAMA');
    $sheet->setCellValue('C10', 'L/P');
    $sheet->setCellValue('D10', 'JABATAN');
    $sheet->setCellValue('E10', 'N I L A I');
    $sheet->mergeCells('E10:F10');

    $sheet->setCellValue('E11', 'PRE TEST');
    $sheet->setCellValue('F11', 'POST TEST');

    $sheet->mergeCells('A10:A11');
    $sheet->mergeCells('B10:B11');
    $sheet->mergeCells('C10:C11');
    $sheet->mergeCells('D10:D11');

    $headerStyle = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'D9E1F2'],
        ],
    ];
    $sheet->getStyle('A10:F11')->applyFromArray($headerStyle);

    $row = 12;
    $no = 1;
    $preSum = 0;
    $postSum = 0;
    $nilaiCount = 0;

    foreach ($jadwal->pendaftars as $peserta) {
        if ($peserta->status_peserta !== 'approved') continue;
        $bio = $peserta->user->biodata;
        if (!$bio) continue;

        $jk = strtoupper($bio->jenis_kelamin) === 'LAKI-LAKI' ? 'L' : 'P';
        $pre = $peserta->pre_test ?? null;
        $post = $peserta->post_test ?? null;

        if (is_numeric($pre)) $preSum += $pre;
        if (is_numeric($post)) $postSum += $post;
        if (is_numeric($pre) || is_numeric($post)) $nilaiCount++;

        $sheet->setCellValue("A{$row}", $no++);
        $sheet->setCellValue("B{$row}", strtoupper($bio->nama));
        $sheet->setCellValue("C{$row}", $jk);
        $sheet->setCellValue("D{$row}", $bio->jabatan);
        $sheet->setCellValue("E{$row}", $pre);
        $sheet->setCellValue("F{$row}", $post);

        $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        $row++;
    }

    $sheet->setCellValue("A{$row}", 'RATA-RATA');
    $sheet->mergeCells("A{$row}:D{$row}");
    $sheet->setCellValue("E{$row}", $nilaiCount ? round($preSum / $nilaiCount, 2) : '');
    $sheet->setCellValue("F{$row}", $nilaiCount ? round($postSum / $nilaiCount, 2) : '');
    $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FBE5D6'],
        ],
    ]);
    $row++;

    $sheet->setCellValue("A{$row}", 'KATEGORI PENILAIAN');
    $sheet->mergeCells("A{$row}:F{$row}");
    $row++;
    $kategori = [
        '81 - 100  :  Sangat Baik',
        '71 - 80    :  Baik',
        '56 - 70    :  Cukup',
        '< 56         :  Kurang',
    ];
    foreach ($kategori as $k) {
        $sheet->setCellValue("A{$row}", $k);
        $sheet->mergeCells("A{$row}:F{$row}");
        $row++;
    }

    foreach (range('A', 'F') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'nilai-pelatihan-' . $jadwal->id . '.xlsx';
    $tempPath = tempnam(sys_get_temp_dir(), $filename);
    $writer->save($tempPath);

    return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
}

}
class CustomPDF extends FPDF
{
    public function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c] ?? 0;
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}
