<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoomFloorPlanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_floor_plan_when_updating_room(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'username' => 'admin1',
            'name' => 'Admin One',
            'email' => 'admin1@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $room = Room::create([
            'nomor_kamar' => '101',
            'lantai' => 1,
            'tipe_kamar' => 'Standard Room',
            'harga_per_malam' => 350000,
            'kapasitas' => 2,
            'deskripsi' => 'Nice room',
            'status' => 'tersedia',
        ]);

        $response = $this->actingAs($admin)->post("/reservasi_hotel/kamar/{$room->id}/update", [
            'tipe_kamar' => 'Standard Room',
            'lantai' => '1',
            'nomor_kamar' => '05',
            'kapasitas' => '2',
            'harga_per_malam' => '350000',
            'status' => 'tersedia',
            'deskripsi' => 'Updated room',
            'denah_kamar_upload' => UploadedFile::fake()->image('denah.jpg'),
        ]);

        $response->assertRedirect();
        $room->refresh();

        $this->assertNotNull($room->denah_kamar);
        $this->assertStringContainsString('storage/gambar/denah', $room->denah_kamar);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $room->denah_kamar));
    }
}
