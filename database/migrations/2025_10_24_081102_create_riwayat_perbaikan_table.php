<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riwayat_perbaikan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->text('deskripsi');
            $table->integer('biaya');
            $table->string('teknisi');
            $table->enum('asset_type', ['aset_tetap', 'atk']);
            $table->unsignedBigInteger('asset_id')->nullable();
            $table->unsignedBigInteger('atk_id')->nullable();
            $table->timestamps();

            // foreign key opsional (kalau tabelnya sudah ada)
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('atk_id')->references('id')->on('atk_items')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_perbaikan');
    }
};
