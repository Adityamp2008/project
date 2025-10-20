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
        Schema::create('atk_usages', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->nullable();
            $table->foreignId('atk_item_id')->constrained('atk_items')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users'); // pemakai / pegawai
            $table->integer('quantity');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atk_usages');
    }
};
