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
        Schema::table('atk_items', function (Blueprint $table) {
            if (!Schema::hasColumn('atk_items', 'room_id')) {
                $table->unsignedBigInteger('room_id')->nullable()->after('kategori_id');
                $table->string('sub_location')->nullable()->after('room_id'); // Rak 12, Lemari A
                // add FK constraint (pastikan migration rooms sudah dibuat dengan timestamp lebih awal)
                $table->foreign('room_id')->references('id')->on('rooms')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atk_items', function (Blueprint $table) {
            if (Schema::hasColumn('atk_items', 'room_id')) {
                $table->dropForeign(['room_id']);
                $table->dropColumn(['room_id', 'sub_location']);
            }
        });
    }
};
