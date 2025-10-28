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
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atk_item_id')->constrained('atk_items')->onDelete('cascade');
            $table->enum('type', ['in', 'out']); // masuk atau keluar
            $table->integer('quantity');
            $table->string('reference')->nullable(); // nota / keterangan
            $table->foreignId('user_id')->nullable()->constrained('users'); // siapa yang melakukan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
    
};
