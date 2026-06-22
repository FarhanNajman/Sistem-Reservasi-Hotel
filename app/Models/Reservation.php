<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'kode_booking',
        'nama_tamu',
        'email_tamu',
        'telepon_tamu',
        'room_id',
        'tanggal_check_in',
        'tanggal_check_out',
        'total_harga',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_check_in' => 'date',
            'tanggal_check_out' => 'date',
        ];
    }

    /**
     * Get the room associated with the reservation.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}

