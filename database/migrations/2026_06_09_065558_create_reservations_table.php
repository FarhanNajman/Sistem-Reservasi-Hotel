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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->string('nama_tamu');
            $table->string('email_tamu');
            $table->string('telepon_tamu');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->date('tanggal_check_in');
            $table->date('tanggal_check_out');
            $table->integer('total_harga');
            $table->string('status')->default('pending'); // pending, dikonfirmasi, check_in, check_out, dibatalkan
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

