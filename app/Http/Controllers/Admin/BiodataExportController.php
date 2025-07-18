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
use App\Models\RegisterPelatihan;
use Illuminate\Support\Str;
use FPDF;
use Illuminate\Http\Request;
use App\Models\Absensi;




require_once base_path('vendor/setasign/fpdf/fpdf.php');

class BiodataExportController extends Controller
{
public function exportKosongPerJadwal($id)
{
    $jadwal = JadwalPelatihan::with(['pendaftars.user.biodata', 'kabupatenkota', 'provinsi'])->findOrFail($id);

    $pdf = new CustomPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    $logoPath = public_path('img/logo-kemendagri.png');
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 15, 5, 20);
    }

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(40, 10);
    $pdf->Cell(0, 5, 'KEMENTERIAN DALAM NEGERI REPUBLIK INDONESIA', 0, 1, 'L');
    $pdf->SetX(40);
    $pdf->Cell(0, 5, 'BALAI BESAR PEMERINTAHAN DESA DI MALANG', 0, 1, 'L');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(0, 8, 'DAFTAR TERIMA TOOLKIT', 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 11);
    $pdf->MultiCell(0, 8, strtoupper($jadwal->judul), 0, 'C');

    $namaKabupaten = strtoupper($jadwal->kabupatenkota->nama ?? '-');
    $provinsi = strtoupper($jadwal->provinsi->nama ?? '-');
    $labelWilayah = Str::startsWith(strtolower($namaKabupaten), 'kota') ? $namaKabupaten : 'KABUPATEN ' . $namaKabupaten;
    $pdf->Cell(0, 8, $labelWilayah . ' PROVINSI ' . $provinsi, 0, 1, 'C');

    // Kosongkan isi tapi sejajarkan rata kiri
    $pdf->SetFont('Arial', 'B', 10);
    $labelWidth = 50;
    $colonWidth = 5;

    $pdf->Cell($labelWidth, 7, 'HARI / TANGGAL', 0, 0, 'L');
    $pdf->Cell($colonWidth, 7, ':', 0, 0, 'L');
    $pdf->Cell(0, 7, '', 0, 1, 'L');


    $pdf->Ln(4);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 12, 'NO', 1, 0, 'C');
    $pdf->Cell(60, 12, 'NAMA LENGKAP', 1, 0, 'C');
    $pdf->Cell(13, 12, 'L / P', 1, 0, 'C');
    $pdf->Cell(72, 12, 'JABATAN DAN ASAL PESERTA', 1, 0, 'C');
    $pdf->Cell(30, 12, 'TANDA TANGAN', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 10);
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

        $cw_no = 10;
        $cw_nama = 60;
        $cw_jk = 13;
        $cw_asal = 72;
        $cw_ttd = 30;

        $lineCount = max(
            $pdf->NbLines($cw_nama, $nama),
            $pdf->NbLines($cw_asal, $textJabatanAsal)
        );
        $rowHeight = $lineCount * 6;

        $x = $pdf->GetX();
        $y = $pdf->GetY();

        $pdf->Cell($cw_no, $rowHeight, $no++, 1, 0, 'C');

        $pdf->SetXY($x + $cw_no, $y);
        $pdf->MultiCell($cw_nama, 6, $nama, 0, 'L');
        $pdf->Rect($x + $cw_no, $y, $cw_nama, $rowHeight);

        $pdf->SetXY($x + $cw_no + $cw_nama, $y);
        $pdf->Cell($cw_jk, $rowHeight, $jk, 1, 0, 'C');

        $pdf->SetXY($x + $cw_no + $cw_nama + $cw_jk, $y);
        $pdf->MultiCell($cw_asal, 6, $textJabatanAsal, 0, 'L');
        $pdf->Rect($x + $cw_no + $cw_nama + $cw_jk, $y, $cw_asal, $rowHeight);

        $pdf->SetXY($x + $cw_no + $cw_nama + $cw_jk + $cw_asal, $y);
        $pdf->Cell($cw_ttd, $rowHeight, '', 1, 1);
    }

    $pdf->Ln(18);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, '       KETUA KELAS,', 0, 1, 'L');
    $pdf->Ln(12);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, '(....................................)', 0, 1, 'L');

    return response()->streamDownload(function () use ($pdf) {
        $pdf->Output();
    }, 'daftar-nilai-kosong-jadwal.pdf');
}

public function exportByJadwal(Request $request, $id)
{
    $tanggal = $request->query('tanggal');

    $jadwal = JadwalPelatihan::with([
        'kabupatenkota', 'provinsi', 'pendaftars.user.biodata', 'pendaftars.absensis'
    ])->findOrFail($id);

    $pdf = new CustomPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    $logoPath = public_path('img/logo-kemendagri.png');
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 15, 5, 20);
    }

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(40, 10);
    $pdf->Cell(0, 5, 'KEMENTERIAN DALAM NEGERI REPUBLIK INDONESIA', 0, 1, 'L');
    $pdf->SetX(40);
    $pdf->Cell(0, 5, 'BALAI BESAR PEMERINTAHAN DESA DI MALANG', 0, 1, 'L');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(0, 8, 'DAFTAR HADIR', 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 11);
    $pdf->MultiCell(0, 8, strtoupper($jadwal->judul), 0, 'C');

    $namaKabupaten = strtoupper($jadwal->kabupatenkota->nama ?? '-');
    $provinsi = strtoupper($jadwal->provinsi->nama ?? '-');
    $labelWilayah = Str::startsWith(strtolower($namaKabupaten), 'kota') ? $namaKabupaten : 'KABUPATEN ' . $namaKabupaten;
    $pdf->Cell(0, 8, $labelWilayah . ' PROVINSI ' . $provinsi, 0, 1, 'C');

    // KOSONGKAN ISI INFORMASI JADWAL
    $pdf->SetFont('Arial', 'B', 10);
    $labelWidth = 50;
    $colonWidth = 5;
    $valueWidth = 0;

    $pdf->Cell($labelWidth, 7, 'HARI / TANGGAL', 0, 0, 'L');
    $pdf->Cell($colonWidth, 7, ':', 0, 0, 'L');
    $pdf->Cell($valueWidth, 7, '', 0, 1, 'L');

    $pdf->Cell($labelWidth, 7, 'WAKTU', 0, 0, 'L');
    $pdf->Cell($colonWidth, 7, ':', 0, 0, 'L');
    $pdf->Cell($valueWidth, 7, '', 0, 1, 'L');

    $pdf->Cell($labelWidth, 7, 'MATERI', 0, 0, 'L');
    $pdf->Cell($colonWidth, 7, ':', 0, 0, 'L');
    $pdf->MultiCell($valueWidth, 7, '', 0, 'L');

    $pdf->Cell($labelWidth, 7, 'TENAGA PENGAJAR', 0, 0, 'L');
    $pdf->Cell($colonWidth, 7, ':', 0, 0, 'L');
    $pdf->MultiCell($valueWidth, 7, '', 0, 'L');

    $pdf->Ln(4);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 12, 'NO', 1, 0, 'C');
    $pdf->Cell(60, 12, 'NAMA LENGKAP', 1, 0, 'C');
    $pdf->Cell(13, 12, 'L / P', 1, 0, 'C');
    $pdf->Cell(72, 12, 'JABATAN DAN ASAL PESERTA', 1, 0, 'C');
    $pdf->Cell(30, 12, 'TANDA TANGAN', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 10);
    $no = 1;

    foreach ($jadwal->pendaftars as $peserta) {
        if ($peserta->status_peserta !== 'approved') continue;
        if ($tanggal && \Carbon\Carbon::parse($peserta->created_at)->toDateString() !== $tanggal) continue;

        $bio = $peserta->user->biodata;
        if (!$bio) continue;

        $nama = strtoupper($bio->nama);
        $jk = strtolower($bio->jenis_kelamin) === 'perempuan' ? 'P' : 'L';
        $jabatan = $bio->jabatan ?? '-';
        $asal = $bio->alamat ?? '-';
        $textJabatanAsal = $jabatan . ' - ' . $asal;

        $cw_no = 10;
        $cw_nama = 60;
        $cw_jk = 13;
        $cw_asal = 72;
        $cw_ttd = 30;

        $lineCount = max(
            $pdf->NbLines($cw_nama, $nama),
            $pdf->NbLines($cw_asal, $textJabatanAsal)
        );
        $rowHeight = $lineCount * 6;

        $x = $pdf->GetX();
        $y = $pdf->GetY();

        $pdf->Cell($cw_no, $rowHeight, $no++, 1, 0, 'C');

        $pdf->SetXY($x + $cw_no, $y);
        $pdf->MultiCell($cw_nama, 6, $nama, 0, 'L');
        $pdf->Rect($x + $cw_no, $y, $cw_nama, $rowHeight);

        $pdf->SetXY($x + $cw_no + $cw_nama, $y);
        $pdf->Cell($cw_jk, $rowHeight, $jk, 1, 0, 'C');

        $pdf->SetXY($x + $cw_no + $cw_nama + $cw_jk, $y);
        $pdf->MultiCell($cw_asal, 6, $textJabatanAsal, 0, 'L');
        $pdf->Rect($x + $cw_no + $cw_nama + $cw_jk, $y, $cw_asal, $rowHeight);

        $pdf->SetXY($x + $cw_no + $cw_nama + $cw_jk + $cw_asal, $y);
        $pdf->Cell($cw_ttd, $rowHeight, '', 1, 1);
    }

    $pdf->Ln(18);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, '       KETUA KELAS,', 0, 1, 'L');
    $pdf->Ln(12);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, '(....................................)', 0, 1, 'L');

    return response()->streamDownload(function () use ($pdf) {
        $pdf->Output();
    }, 'daftar-hadir-filtered.pdf');
}
public function exportExcelByJadwal(Request $request, $id)
{
    $jadwal = JadwalPelatihan::with(['provinsi', 'kabupatenkota'])->findOrFail($id);

    $pendaftars = RegisterPelatihan::with('user.biodata')
        ->where('jadwal_pelatihan_id', $id)
        ->where('status_peserta', 'approved')
        ->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Logo
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

    $wilayahLine = Str::startsWith($kabupatenkotaNama, 'KOTA')
        ? "{$kabupatenkotaNama} PROVINSI {$provinsiNama}"
        : "KABUPATEN {$kabupatenkotaNama} PROVINSI {$provinsiNama}";
    $sheet->setCellValue('A6', $wilayahLine);

    $sheet->getStyle('A4:A6')->getFont()->setBold(true)->setSize(13);
    $sheet->getStyle('A4:A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Hilangkan tanggal absen dan ganti dengan tanggal export
    $sheet->setCellValue('A8', 'Hari/Tanggal : ' );
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

    foreach ($pendaftars as $peserta) {
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
