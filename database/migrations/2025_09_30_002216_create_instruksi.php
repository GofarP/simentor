<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instruksis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pengirim_id');
            $table->bigInteger('penerima_id');
            $table->string('judul');
            $table->longText('deskripsi');
            $table->longText('waktu_mulai');
            $table->date('batas_waktu');
            $table->string('lampiran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instruksi');
    }
};
