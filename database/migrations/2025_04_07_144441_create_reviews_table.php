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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // pastikan tabel 'users' dan 'pesanans' sudah ada sebelum migrasi ini dijalankan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');

            $table->tinyInteger('rating'); // nilai rating dari 1-5
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
