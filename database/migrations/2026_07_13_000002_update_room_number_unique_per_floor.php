<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('rooms', 'nomor_kamar') && Schema::hasColumn('rooms', 'lantai')) {
            DB::statement('DROP INDEX IF EXISTS rooms_nomor_kamar_unique');
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS rooms_lantai_nomor_kamar_unique ON rooms (lantai, nomor_kamar)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('rooms', 'nomor_kamar') && Schema::hasColumn('rooms', 'lantai')) {
            DB::statement('DROP INDEX IF EXISTS rooms_lantai_nomor_kamar_unique');
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS rooms_nomor_kamar_unique ON rooms (nomor_kamar)');
        }
    }
};
