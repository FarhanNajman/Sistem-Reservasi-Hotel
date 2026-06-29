<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login page loads.
     */
    public function test_login_page_loads(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang');
    }

    /**
     * Test registration page loads.
     */
    public function test_register_page_loads(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Buat Akun Baru');
    }

    /**
     * Test guest redirected when booking room.
     */
    public function test_guest_redirected_to_login_on_booking(): void
    {
        $response = $this->get('/reservasi/pesan/1');

        $response->assertRedirect('/login');
        $response->assertSessionHas('error', 'Silakan login terlebih dahulu untuk melakukan pemesanan.');
    }

    /**
     * Test user registration.
     */
    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/reservasi_hotel');
        $response->assertSessionHas('success', 'Akun Anda berhasil didaftarkan dan Anda telah masuk!');
        
        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
        $this->assertAuthenticated();
    }

    /**
     * Test user login.
     */
    public function test_user_can_login(): void
    {
        $user = User::create([
            'username' => 'myuser',
            'email' => 'myuser@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'myuser',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/reservasi_hotel');
        $response->assertSessionHas('success', 'Selamat datang kembali, myuser!');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test auth user booking room.
     */
    public function test_authenticated_user_can_book_room(): void
    {
        $user = User::create([
            'username' => 'myuser',
            'email' => 'myuser@example.com',
            'password' => bcrypt('password123'),
        ]);

        $room = Room::create([
            'nomor_kamar' => '101',
            'tipe_kamar' => 'Standard Room',
            'harga_per_malam' => 350000,
            'kapasitas' => 2,
            'deskripsi' => 'Nice room',
            'status' => 'tersedia',
        ]);

        $response = $this->actingAs($user)->get("/reservasi/pesan/{$room->id}");

        $response->assertRedirect('/reservasi_hotel');
        $response->assertSessionHas('success', 'Kamar No. 101 (Standard Room) berhasil dipilih! Fitur pengisian data pesanan segera hadir.');
    }
}
