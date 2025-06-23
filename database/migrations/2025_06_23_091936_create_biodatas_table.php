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
    Schema::create('biodatas', function (Blueprint $table) {
        $table->id(); // ID Peserta
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nama');
        $table->text('alamat');
        $table->unsignedBigInteger('id_desa'); // nanti bisa relasi jika ada
        $table->string('nik', 16)->unique();
        $table->string('npwp')->nullable(); // Optional
        $table->string('tempat_lahir');
        $table->date('tanggal_lahir');
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->string('agama'); // Pilihan (nanti di form)
        $table->string('status_kawin'); // Pilihan (nanti di form)
        $table->string('jabatan');
        $table->integer('lama_menjabat'); // tahun
        $table->string('nomor_sk_jabatan');
        $table->string('pendidikan'); // Pilihan dan opsi "lainnya"
        $table->string('no_telp');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodatas');
    }
};
