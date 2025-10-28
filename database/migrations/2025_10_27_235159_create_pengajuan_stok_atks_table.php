<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_stok_atks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atk_item_id')->constrained('atk_items')->onDelete('cascade');
            $table->enum('jenis', ['in', 'out']); // tambah stok / kurangi stok
            $table->integer('jumlah');
            $table->string('keterangan')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_stok_atks');
    }
};
