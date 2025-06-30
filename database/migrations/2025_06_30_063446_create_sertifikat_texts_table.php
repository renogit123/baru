<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikatTextsTable extends Migration
{
    public function up()
    {
        Schema::create('sertifikat_texts', function (Blueprint $table) {
            $table->id();
            $table->text('deskripsi_atas')->nullable();
            $table->string('judul_tengah')->nullable();
            $table->text('deskripsi_bawah')->nullable();
            $table->string('penandatangan')->nullable();
            $table->string('jabatan_penandatangan')->nullable();
            $table->string('nip_penandatangan')->nullable();
            $table->date('tanggal_sertifikat')->nullable();
            $table->string('kota_penetapan')->nullable();
            $table->date('tanggal_penetapan')->nullable();
            $table->string('jabatan_penetapan')->nullable();
            $table->string('nomor_sertifikat')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sertifikat_texts');
    }
}
