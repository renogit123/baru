<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kabupaten_kotaSeeder extends Seeder

{
    public function run(): void
    {
        $provinsiMap = DB::table('provinsis')->pluck('id', 'kode');

        $kabupaten_kotas = [
            ['kode' => '35.01', 'nama' => 'PACITAN', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.02', 'nama' => 'PONOROGO', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.03', 'nama' => 'TRENGGALEK', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.04', 'nama' => 'TULUNGAGUNG', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.05', 'nama' => 'BLITAR', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.06', 'nama' => 'KEDIRI', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.07', 'nama' => 'MALANG', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.08', 'nama' => 'LUMAJANG', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.09', 'nama' => 'JEMBER', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.10', 'nama' => 'BANYUWANGI', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.11', 'nama' => 'BONDOWOSO', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.12', 'nama' => 'SITUBONDO', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.13', 'nama' => 'PROBOLINGGO', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.14', 'nama' => 'PASURUAN', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.15', 'nama' => 'SIDOARJO', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.16', 'nama' => 'MOJOKERTO', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.17', 'nama' => 'JOMBANG', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.18', 'nama' => 'NGANJUK', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.19', 'nama' => 'MADIUN', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.20', 'nama' => 'MAGETAN', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.21', 'nama' => 'NGAWI', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.22', 'nama' => 'BOJONEGORO', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.23', 'nama' => 'TUBAN', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.24', 'nama' => 'LAMONGAN', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.25', 'nama' => 'GRESIK', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.26', 'nama' => 'BANGKALAN', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.27', 'nama' => 'SAMPANG', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.28', 'nama' => 'PAMEKASAN', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.29', 'nama' => 'SUMENEP', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.71', 'nama' => 'KOTA KEDIRI', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.72', 'nama' => 'KOTA BLITAR', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.73', 'nama' => 'KOTA MALANG', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.74', 'nama' => 'KOTA PROBOLINGGO', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.75', 'nama' => 'KOTA PASURUAN', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.76', 'nama' => 'KOTA MOJOKERTO', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.77', 'nama' => 'KOTA MADIUN', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.78', 'nama' => 'KOTA SURABAYA', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '35.79', 'nama' => 'KOTA BATU', 'provinsi_id' => $provinsiMap['35']],
            ['kode' => '51.01', 'nama' => 'JEMBRANA', 'provinsi_id' => $provinsiMap['51']],
            ['kode' => '51.02', 'nama' => 'TABANAN', 'provinsi_id' => $provinsiMap['51']],
            ['kode' => '51.03', 'nama' => 'BADUNG', 'provinsi_id' => $provinsiMap['51']],
            ['kode' => '51.04', 'nama' => 'GIANYAR', 'provinsi_id' => $provinsiMap['51']],
            ['kode' => '51.05', 'nama' => 'KLUNGKUNG', 'provinsi_id' => $provinsiMap['51']],
            ['kode' => '51.06', 'nama' => 'BANGLI', 'provinsi_id' => $provinsiMap['51']],
            ['kode' => '51.07', 'nama' => 'KARANGASEM', 'provinsi_id' => $provinsiMap['51']],
            ['kode' => '51.08', 'nama' => 'BULELENG', 'provinsi_id' => $provinsiMap['51']],
            ['kode' => '51.71', 'nama' => 'KOTA DENPASAR', 'provinsi_id' => $provinsiMap['51']],
            ['kode' => '52.01', 'nama' => 'LOMBOK BARAT', 'provinsi_id' => $provinsiMap['52']],
            ['kode' => '52.02', 'nama' => 'LOMBOK TENGAH', 'provinsi_id' => $provinsiMap['52']],
            ['kode' => '52.03', 'nama' => 'LOMBOK TIMUR', 'provinsi_id' => $provinsiMap['52']],
            ['kode' => '52.04', 'nama' => 'SUMBAWA', 'provinsi_id' => $provinsiMap['52']],
            ['kode' => '52.05', 'nama' => 'DOMPU', 'provinsi_id' => $provinsiMap['52']],
            ['kode' => '52.06', 'nama' => 'BIMA', 'provinsi_id' => $provinsiMap['52']],
            ['kode' => '52.07', 'nama' => 'SUMBAWA BARAT', 'provinsi_id' => $provinsiMap['52']],
            ['kode' => '52.08', 'nama' => 'LOMBOK UTARA', 'provinsi_id' => $provinsiMap['52']],
            ['kode' => '52.71', 'nama' => 'KOTA MATARAM', 'provinsi_id' => $provinsiMap['52']],
            ['kode' => '52.72', 'nama' => 'KOTA BIMA', 'provinsi_id' => $provinsiMap['52']],
            ['kode' => '53.01', 'nama' => 'KUPANG', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.02', 'nama' => 'KAB TIMOR TENGAH SELATAN', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.03', 'nama' => 'TIMOR TENGAH UTARA', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.04', 'nama' => 'BELU', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.05', 'nama' => 'ALOR', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.06', 'nama' => 'FLORES TIMUR', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.07', 'nama' => 'SIKKA', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.08', 'nama' => 'ENDE', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.09', 'nama' => 'NGADA', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.10', 'nama' => 'MANGGARAI', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.11', 'nama' => 'SUMBA TIMUR', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.12', 'nama' => 'SUMBA BARAT', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.13', 'nama' => 'LEMBATA', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.14', 'nama' => 'ROTE NDAO', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.15', 'nama' => 'MANGGARAI BARAT', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.16', 'nama' => 'NAGEKEO', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.17', 'nama' => 'SUMBA TENGAH', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.18', 'nama' => 'SUMBA BARAT DAYA', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.19', 'nama' => 'MANGGARAI TIMUR', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.20', 'nama' => 'SABU RAIJUA', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.21', 'nama' => 'MALAKA', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '53.71', 'nama' => 'KOTA KUPANG', 'provinsi_id' => $provinsiMap['53']],
            ['kode' => '71.01', 'nama' => 'BOLAANG MONGONDOW', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.02', 'nama' => 'MINAHASA', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.03', 'nama' => 'KEPULAUAN SANGIHE', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.04', 'nama' => 'KEPULAUAN TALAUD', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.05', 'nama' => 'MINAHASA SELATAN', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.06', 'nama' => 'MINAHASA UTARA', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.07', 'nama' => 'MINAHASA TENGGARA', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.08', 'nama' => 'BOLAANG MONGONDOW UTARA', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.09', 'nama' => 'KEP. SIAU TAGULANDANG BIARO', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.10', 'nama' => 'BOLAANG MONGONDOW TIMUR', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.11', 'nama' => 'BOLAANG MONGONDOW SELATAN', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.71', 'nama' => 'KOTA MANADO', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.72', 'nama' => 'KOTA BITUNG', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.73', 'nama' => 'KOTA TOMOHON', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '71.74', 'nama' => 'KOTA KOTAMOBAGU', 'provinsi_id' => $provinsiMap['71']],
            ['kode' => '72.01', 'nama' => 'BANGGAI', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.02', 'nama' => 'POSO', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.03', 'nama' => 'DONGGALA', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.04', 'nama' => 'TOLI TOLI', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.05', 'nama' => 'BUOL', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.06', 'nama' => 'MOROWALI', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.07', 'nama' => 'BANGGAI KEPULAUAN', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.08', 'nama' => 'PARIGI MOUTONG', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.09', 'nama' => 'TOJO UNA UNA', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.10', 'nama' => 'SIGI', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.11', 'nama' => 'BANGGAI LAUT', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.12', 'nama' => 'MOROWALI UTARA', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '72.71', 'nama' => 'KOTA PALU', 'provinsi_id' => $provinsiMap['72']],
            ['kode' => '73.01', 'nama' => 'KEPULAUAN SELAYAR', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.02', 'nama' => 'BULUKUMBA', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.03', 'nama' => 'BANTAENG', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.04', 'nama' => 'JENEPONTO', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.05', 'nama' => 'TAKALAR', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.06', 'nama' => 'GOWA', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.07', 'nama' => 'SINJAI', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.08', 'nama' => 'BONE', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.09', 'nama' => 'MAROS', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.10', 'nama' => 'PANGKAJENE DAN KEPULAUAN', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.11', 'nama' => 'BARRU', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.12', 'nama' => 'SOPPENG', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.13', 'nama' => 'WAJO', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.14', 'nama' => 'SIDENRENG RAPPANG', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.15', 'nama' => 'PINRANG', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.16', 'nama' => 'ENREKANG', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.17', 'nama' => 'LUWU', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.18', 'nama' => 'TANA TORAJA', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.22', 'nama' => 'LUWU UTARA', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.24', 'nama' => 'LUWU TIMUR', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.26', 'nama' => 'TORAJA UTARA', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.71', 'nama' => 'KOTA MAKASSAR', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.72', 'nama' => 'KOTA PAREPARE', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '73.73', 'nama' => 'KOTA PALOPO', 'provinsi_id' => $provinsiMap['73']],
            ['kode' => '74.01', 'nama' => 'KOLAKA', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.02', 'nama' => 'KONAWE', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.03', 'nama' => 'MUNA', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.04', 'nama' => 'BUTON', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.05', 'nama' => 'KONAWE SELATAN', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.06', 'nama' => 'BOMBANA', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.07', 'nama' => 'WAKATOBI', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.08', 'nama' => 'KOLAKA UTARA', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.09', 'nama' => 'KONAWE UTARA', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.10', 'nama' => 'BUTON UTARA', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.11', 'nama' => 'KOLAKA TIMUR', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.12', 'nama' => 'KONAWE KEPULAUAN', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.13', 'nama' => 'MUNA BARAT', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.14', 'nama' => 'BUTON TENGAH', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.15', 'nama' => 'BUTON SELATAN', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.71', 'nama' => 'KOTA KENDARI', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '74.72', 'nama' => 'KOTA BAU BAU', 'provinsi_id' => $provinsiMap['74']],
            ['kode' => '75.01', 'nama' => 'GORONTALO', 'provinsi_id' => $provinsiMap['75']],
            ['kode' => '75.02', 'nama' => 'BOALEMO', 'provinsi_id' => $provinsiMap['75']],
            ['kode' => '75.03', 'nama' => 'BONE BOLANGO', 'provinsi_id' => $provinsiMap['75']],
            ['kode' => '75.04', 'nama' => 'POHUWATO', 'provinsi_id' => $provinsiMap['75']],
            ['kode' => '75.05', 'nama' => 'GORONTALO UTARA', 'provinsi_id' => $provinsiMap['75']],
            ['kode' => '75.71', 'nama' => 'KOTA GORONTALO', 'provinsi_id' => $provinsiMap['75']],
            ['kode' => '76.01', 'nama' => 'PASANGKAYU', 'provinsi_id' => $provinsiMap['76']],
            ['kode' => '76.02', 'nama' => 'MAMUJU', 'provinsi_id' => $provinsiMap['76']],
            ['kode' => '76.03', 'nama' => 'MAMASA', 'provinsi_id' => $provinsiMap['76']],
            ['kode' => '76.04', 'nama' => 'POLEWALI MANDAR', 'provinsi_id' => $provinsiMap['76']],
            ['kode' => '76.05', 'nama' => 'MAJENE', 'provinsi_id' => $provinsiMap['76']],
            ['kode' => '76.06', 'nama' => 'MAMUJU TENGAH', 'provinsi_id' => $provinsiMap['76']],
            ['kode' => '81.01', 'nama' => 'MALUKU TENGAH', 'provinsi_id' => $provinsiMap['81']],
            ['kode' => '81.02', 'nama' => 'MALUKU TENGGARA', 'provinsi_id' => $provinsiMap['81']],
            ['kode' => '81.03', 'nama' => 'KEPULAUAN TANIMBAR', 'provinsi_id' => $provinsiMap['81']],
            ['kode' => '81.04', 'nama' => 'BURU', 'provinsi_id' => $provinsiMap['81']],
            ['kode' => '81.05', 'nama' => 'SERAM BAGIAN TIMUR', 'provinsi_id' => $provinsiMap['81']],
            ['kode' => '81.06', 'nama' => 'SERAM BAGIAN BARAT', 'provinsi_id' => $provinsiMap['81']],
            ['kode' => '81.07', 'nama' => 'KEPULAUAN ARU', 'provinsi_id' => $provinsiMap['81']],
            ['kode' => '81.08', 'nama' => 'MALUKU BARAT DAYA', 'provinsi_id' => $provinsiMap['81']],
            ['kode' => '81.09', 'nama' => 'BURU SELATAN', 'provinsi_id' => $provinsiMap['81']],
            ['kode' => '81.71', 'nama' => 'KOTA AMBON', 'provinsi_id' => $provinsiMap['81']],
            ['kode' => '81.72', 'nama' => 'KOTA TUAL', 'provinsi_id' => $provinsiMap['81']],
            ['kode' => '82.01', 'nama' => 'HALMAHERA BARAT', 'provinsi_id' => $provinsiMap['82']],
            ['kode' => '82.02', 'nama' => 'HALMAHERA TENGAH', 'provinsi_id' => $provinsiMap['82']],
            ['kode' => '82.03', 'nama' => 'HALMAHERA UTARA', 'provinsi_id' => $provinsiMap['82']],
            ['kode' => '82.04', 'nama' => 'HALMAHERA SELATAN', 'provinsi_id' => $provinsiMap['82']],
            ['kode' => '82.05', 'nama' => 'KEPULAUAN SULA', 'provinsi_id' => $provinsiMap['82']],
            ['kode' => '82.06', 'nama' => 'HALMAHERA TIMUR', 'provinsi_id' => $provinsiMap['82']],
            ['kode' => '82.07', 'nama' => 'PULAU MOROTAI', 'provinsi_id' => $provinsiMap['82']],
            ['kode' => '82.08', 'nama' => 'PULAU TALIABU', 'provinsi_id' => $provinsiMap['82']],
            ['kode' => '82.71', 'nama' => 'KOTA TERNATE', 'provinsi_id' => $provinsiMap['82']],
            ['kode' => '82.72', 'nama' => 'KOTA TIDORE KEPULAUAN', 'provinsi_id' => $provinsiMap['82']],
            ['kode' => '91.03', 'nama' => 'JAYAPURA', 'provinsi_id' => $provinsiMap['91']],
            ['kode' => '91.05', 'nama' => 'KEPULAUAN YAPEN', 'provinsi_id' => $provinsiMap['91']],
            ['kode' => '91.06', 'nama' => 'BIAK NUMFOR', 'provinsi_id' => $provinsiMap['91']],
            ['kode' => '91.10', 'nama' => 'SARMI', 'provinsi_id' => $provinsiMap['91']],
            ['kode' => '91.11', 'nama' => 'KEEROM', 'provinsi_id' => $provinsiMap['91']],
            ['kode' => '91.15', 'nama' => 'WAROPEN', 'provinsi_id' => $provinsiMap['91']],
            ['kode' => '91.19', 'nama' => 'SUPIORI', 'provinsi_id' => $provinsiMap['91']],
            ['kode' => '91.20', 'nama' => 'MAMBERAMO RAYA', 'provinsi_id' => $provinsiMap['91']],
            ['kode' => '91.71', 'nama' => 'KOTA JAYAPURA', 'provinsi_id' => $provinsiMap['91']],
            ['kode' => '92.02', 'nama' => 'MANOKWARI', 'provinsi_id' => $provinsiMap['92']],
            ['kode' => '92.03', 'nama' => 'FAK FAK', 'provinsi_id' => $provinsiMap['92']],
            ['kode' => '92.06', 'nama' => 'TELUK BINTUNI', 'provinsi_id' => $provinsiMap['92']],
            ['kode' => '92.07', 'nama' => 'TELUK WONDAMA', 'provinsi_id' => $provinsiMap['92']],
            ['kode' => '92.08', 'nama' => 'KAIMANA', 'provinsi_id' => $provinsiMap['92']],
            ['kode' => '92.11', 'nama' => 'MANOKWARI SELATAN', 'provinsi_id' => $provinsiMap['92']],
            ['kode' => '92.12', 'nama' => 'PEGUNUNGAN ARFAK', 'provinsi_id' => $provinsiMap['92']],
            ['kode' => '93.01', 'nama' => 'MERAUKE', 'provinsi_id' => $provinsiMap['93']],
            ['kode' => '93.02', 'nama' => 'BOVEN DIGOEL', 'provinsi_id' => $provinsiMap['93']],
            ['kode' => '93.03', 'nama' => 'MAPPI', 'provinsi_id' => $provinsiMap['93']],
            ['kode' => '93.04', 'nama' => 'ASMAT', 'provinsi_id' => $provinsiMap['93']],
            ['kode' => '94.01', 'nama' => 'NABIRE', 'provinsi_id' => $provinsiMap['94']],
            ['kode' => '94.02', 'nama' => 'PUNCAK JAYA', 'provinsi_id' => $provinsiMap['94']],
            ['kode' => '94.03', 'nama' => 'PANIAI', 'provinsi_id' => $provinsiMap['94']],
            ['kode' => '94.04', 'nama' => 'MIMIKA', 'provinsi_id' => $provinsiMap['94']],
            ['kode' => '94.05', 'nama' => 'PUNCAK', 'provinsi_id' => $provinsiMap['94']],
            ['kode' => '94.06', 'nama' => 'DOGIYAI', 'provinsi_id' => $provinsiMap['94']],
            ['kode' => '94.07', 'nama' => 'INTAN JAYA', 'provinsi_id' => $provinsiMap['94']],
            ['kode' => '94.08', 'nama' => 'DEIYAI', 'provinsi_id' => $provinsiMap['94']],
            ['kode' => '95.01', 'nama' => 'JAYAWIJAYA', 'provinsi_id' => $provinsiMap['95']],
            ['kode' => '95.02', 'nama' => 'KAB PEGUNUNGAN BINTANG', 'provinsi_id' => $provinsiMap['95']],
            ['kode' => '95.03', 'nama' => 'YAHUKIMO', 'provinsi_id' => $provinsiMap['95']],
            ['kode' => '95.04', 'nama' => 'TOLIKARA', 'provinsi_id' => $provinsiMap['95']],
            ['kode' => '95.05', 'nama' => 'MAMBERAMO TENGAH', 'provinsi_id' => $provinsiMap['95']],
            ['kode' => '95.06', 'nama' => 'YALIMO', 'provinsi_id' => $provinsiMap['95']],
            ['kode' => '95.07', 'nama' => 'LANNY JAYA', 'provinsi_id' => $provinsiMap['95']],
            ['kode' => '95.08', 'nama' => 'NDUGA', 'provinsi_id' => $provinsiMap['95']],
            ['kode' => '96.01', 'nama' => 'SORONG', 'provinsi_id' => $provinsiMap['96']],
            ['kode' => '96.02', 'nama' => 'SORONG SELATAN', 'provinsi_id' => $provinsiMap['96']],
            ['kode' => '96.03', 'nama' => 'RAJA AMPAT', 'provinsi_id' => $provinsiMap['96']],
            ['kode' => '96.04', 'nama' => 'TAMBRAUW', 'provinsi_id' => $provinsiMap['96']],
            ['kode' => '96.05', 'nama' => 'MAYBRAT', 'provinsi_id' => $provinsiMap['96']],
            ['kode' => '96.71', 'nama' => 'KOTA SORONG', 'provinsi_id' => $provinsiMap['96']],
        ];
        DB::table('kabupaten_kotas')->insert($kabupaten_kotas);
    }
}