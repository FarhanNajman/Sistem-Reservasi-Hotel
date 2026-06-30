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
}
