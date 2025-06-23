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
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->enum('pembiayaan', ['RM', 'PNBP']);
            $table->string('kelas');
            $table->boolean('status')->default(true); // Aktif / Tidak Aktif
            $table->timestamps();
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
