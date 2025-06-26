<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jadwal_pelatihan_baru', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->timestamps(); // <-- tambahkan baris ini
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pelatihan_baru');
    }
};
