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
        Schema::create('pengajuan_stok_atk', function (Blueprint $table) {
    $table->id();
    $table->foreignId('atk_item_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->enum('jenis', ['in', 'out']); // masuk / keluar
    $table->integer('jumlah');
    $table->string('keterangan')->nullable();
    $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_stok_atk');
    }
};
