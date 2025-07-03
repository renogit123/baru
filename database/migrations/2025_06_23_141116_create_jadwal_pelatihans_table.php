<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jadwal_pelatihans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->unsignedBigInteger('provinsi_id')->nullable();
            $table->unsignedBigInteger('kabupaten_id')->nullable();
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->enum('pembiayaan', ['RM', 'PNBP']);
            $table->string('kelas');
            $table->boolean('status')->default(true); // Aktif / Tidak Aktif
            $table->timestamps();

            // Optional: jika kamu ingin buat foreign key
            // pastikan tabel `provinsis` dan `kabupatens` sudah ada
            // $table->foreign('provinsi_id')->references('id')->on('provinsis');
            // $table->foreign('kabupaten_id')->references('id')->on('kabupatens');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pelatihans');
    }
};
