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
        Schema::create('register_pelatihans', function (Blueprint $table) {
            $table->id();
    
            // Relasi ke users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
    
            // Relasi ke jadwal_pelatihans (perlu disebutkan nama tabel karena nama kolom bukan 'jadwal_pelatihan_id' secara otomatis dikenali)
            $table->foreignId('jadwal_pelatihan_id')
                  ->constrained('jadwal_pelatihans')
                  ->onDelete('cascade');
    
            // Status pendaftaran
            $table->enum('status_peserta', ['pending', 'approved'])->default('pending');
    
            // Status kehadiran (misal untuk absen nantinya)
            $table->enum('status_kehadiran', ['belum_hadir', 'hadir'])->default('belum_hadir');
    
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_pelatihans');
    }
};
