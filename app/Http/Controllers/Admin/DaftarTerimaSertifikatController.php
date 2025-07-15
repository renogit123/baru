<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelatihan;
use Illuminate\Support\Str;
use FPDF;
use Carbon\Carbon;

class DaftarTerimaSertifikatController extends Controller
{
    public function export($id)
    {
        $tanggal = request('tanggal'); // ambil dari query ?tanggal=YYYY-MM-DD
        if (!$tanggal) {
            abort(404, 'Parameter tanggal tidak ditemukan.');
        }

        $jadwal = JadwalPelatihan::with([
            'pendaftars.user.biodata',
            'pendaftars.absensis', // relasi absensi
            'kabupatenkota',
            'provinsi'
        ])->findOrFail($id);

        $pesertas = $jadwal->pendaftars->filter(function ($p) use ($tanggal) {
            return $p->user->biodata?->is_approved &&
                   $p->absensis->where('tanggal_absen', $tanggal)->isNotEmpty();
        });

        if ($pesertas->isEmpty()) {
            abort(404, '❌ Tidak ada peserta yang hadir dan disetujui pada tanggal ini.');
        }

        $pdf = new CustomPDF('P', 'mm', 'A4'); // Portrait
        $pdf->AddPage();

        // Logo dan header
        $logoPath = public_path('img/logo-kemendagri.png');
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 15, 5, 20);
        }

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(40, 10);
        $pdf->Cell(0, 5, 'KEMENTERIAN DALAM NEGERI REPUBLIK INDONESIA', 0, 1, 'L');
        $pdf->SetX(40);
        $pdf->Cell(0, 5, 'BALAI BESAR PEMERINTAHAN DESA DI MALANG', 0, 1, 'L');

        // Judul
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(0, 8, 'DAFTAR TERIMA SERTIFIKAT', 0, 1, 'C');

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->MultiCell(0, 8, strtoupper($jadwal->judul), 0, 'C');

        $kab = strtoupper($jadwal->kabupatenkota->nama ?? '-');
        $prov = strtoupper($jadwal->provinsi->nama ?? '-');
        $labelWilayah = Str::startsWith(strtolower($kab), 'kota') ? $kab : 'KABUPATEN ' . $kab;
        $pdf->Cell(0, 8, $labelWilayah . ' PROVINSI ' . $prov, 0, 1, 'C');

        $pdf->Ln(4);

        // Header tabel
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 12, 'NO', 1, 0, 'C');
        $pdf->Cell(65, 12, 'NAMA LENGKAP', 1, 0, 'C');
        $pdf->Cell(13, 12, 'L/P', 1, 0, 'C');
        $pdf->Cell(72, 12, 'JABATAN DAN ASAL PESERTA', 1, 0, 'C');
        $pdf->Cell(30, 12, 'TANDA TANGAN', 1, 1, 'C');

        // Isi tabel
        $pdf->SetFont('Arial', '', 10);
        $no = 1;
        foreach ($pesertas as $peserta) {
            $bio = $peserta->user->biodata;
            if (!$bio) continue;

            $nama = strtoupper($bio->nama);
            $jk = strtolower($bio->jenis_kelamin) === 'perempuan' ? 'P' : 'L';
            $jabatan = $bio->jabatan ?? '-';
            $asal = $bio->alamat ?? '-';
            $textJabatanAsal = $jabatan . ' - ' . $asal;

            // Cell widths
            $cw_no = 10;
            $cw_nama = 65;
            $cw_jk = 13;
            $cw_asal = 72;
            $cw_ttd = 30;

            // Hitung tinggi baris dinamis
            $lineCount = max(
                $pdf->NbLines($cw_nama, $nama),
                $pdf->NbLines($cw_asal, $textJabatanAsal)
            );
            $rowHeight = $lineCount * 6;

            $x = $pdf->GetX();
            $y = $pdf->GetY();

            // NO
            $pdf->Cell($cw_no, $rowHeight, $no++, 1, 0, 'C');

            // NAMA
            $pdf->SetXY($x + $cw_no, $y);
            $pdf->MultiCell($cw_nama, 6, $nama, 0, 'L');
            $pdf->Rect($x + $cw_no, $y, $cw_nama, $rowHeight);

            // JK
            $pdf->SetXY($x + $cw_no + $cw_nama, $y);
            $pdf->Cell($cw_jk, $rowHeight, $jk, 1, 0, 'C');

            // ASAL
            $pdf->SetXY($x + $cw_no + $cw_nama + $cw_jk, $y);
            $pdf->MultiCell($cw_asal, 6, $textJabatanAsal, 0, 'L');
            $pdf->Rect($x + $cw_no + $cw_nama + $cw_jk, $y, $cw_asal, $rowHeight);

            // TTD
            $pdf->SetXY($x + $cw_no + $cw_nama + $cw_jk + $cw_asal, $y);
            $pdf->Cell($cw_ttd, $rowHeight, '', 1, 1);
        }

        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output();
        }, 'daftar-terima-sertifikat-tanggal-' . $tanggal . '.pdf');
    }
}


class CustomPDF extends FPDF
{
    // Tambahan fungsi bantu untuk menghitung tinggi baris teks otomatis
    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
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
            $l += $cw[$c];
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
            } else
                $i++;
        }
        return $nl;
    }
}
