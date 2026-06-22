<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'nomor_kamar',
        'tipe_kamar',
        'harga_per_malam',
        'kapasitas',
        'deskripsi',
        'foto_kamar',
        'status',
    ];

    /**
     * Get the reservations for the room.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'room_id');
    }
}

