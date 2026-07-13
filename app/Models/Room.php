<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model

{
    protected $table = 'rooms';

    protected $fillable = [
        'nomor_kamar',
        'lantai',
        'tipe_kamar',
        'harga_per_malam',
        'kapasitas',
        'deskripsi',
        'foto_kamar',
        'denah_kamar',
        'status',
        'fasilitas',
    ];

    protected $casts = [
        'fasilitas' => 'array',
    ];

    public static function normalizeNomorKamar(int $lantai, string $nomorKamar): string
    {
        $digits = preg_replace('/\D/', '', $nomorKamar) ?: '01';
        $digits = substr($digits, -2);

        if (strlen($digits) === 2 && str_starts_with($digits, (string) $lantai)) {
            return $digits;
        }

        return (string) $lantai . str_pad($digits, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Get the reservations for the room.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'room_id');
    }
}

