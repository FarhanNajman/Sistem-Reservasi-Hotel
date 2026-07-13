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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->unsignedTinyInteger('lantai')->default(1);
            $table->string('tipe_kamar');
            $table->integer('harga_per_malam');
            $table->integer('kapasitas');
            $table->text('deskripsi')->nullable();
            $table->string('foto_kamar')->nullable();
            $table->string('status')->default('tersedia'); 
            // tersedia, perbaikan, penuh
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

