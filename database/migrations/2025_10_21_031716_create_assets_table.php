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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('cascade');
            $table->string('lokasi')->nullable();
            $table->date('tanggal_perolehan')->nullable();
            $table->integer('umur_tahun')->nullable();
            $table->string('kondisi')->nullable();
            $table->boolean('pernah_diperbaiki')->default(false); // dihitung otomatis
            $table->string('kelayakan')->nullable(); // dihitung otomatis
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
