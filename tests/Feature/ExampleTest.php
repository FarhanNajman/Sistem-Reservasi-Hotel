<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/reservasi_hotel');

        $response->assertStatus(200);
    }

    public function test_room_details_page_returns_successful_response(): void
    {
        $this->seed();
        $room = \App\Models\Room::first();
        
        $response = $this->get('/reservasi_hotel/kamar/' . $room->id);
        
        $response->assertStatus(200);
        $response->assertSee($room->tipe_kamar);
        $response->assertSee('Kamar No. ' . $room->nomor_kamar);
    }

    public function test_role_middleware_redirects_guest(): void
    {
        \Illuminate\Support\Facades\Route::get('/_test_admin_route', function () {
            return 'success';
        })->middleware('role:admin');

        $response = $this->get('/_test_admin_route');
        $response->assertRedirect(route('login'));
    }

    public function test_role_middleware_blocks_non_admin(): void
    {
        \Illuminate\Support\Facades\Route::get('/_test_admin_route_block', function () {
            return 'success';
        })->middleware('role:admin');

        $user = \App\Models\User::create([
            'username' => 'testuser',
            'email' => 'testuser@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)->get('/_test_admin_route_block');
        $response->assertRedirect('/reservasi_hotel');
        $response->assertSessionHas('error', 'Anda tidak memiliki wewenang untuk mengakses halaman admin.');
    }

    public function test_role_middleware_allows_admin(): void
    {
        \Illuminate\Support\Facades\Route::get('/_test_admin_route_ok', function () {
            return 'success';
        })->middleware('role:admin');

        $admin = \App\Models\User::create([
            'username' => 'testadmin',
            'email' => 'testadmin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->get('/_test_admin_route_ok');
        $response->assertStatus(200);
        $response->assertSee('success');
    }
}
