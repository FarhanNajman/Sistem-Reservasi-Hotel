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
        if (!Schema::hasColumn('rooms', 'denah_kamar')) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->string('denah_kamar')->nullable()->after('foto_kamar');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('rooms', 'denah_kamar')) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->dropColumn('denah_kamar');
            });
        }
    }
};
