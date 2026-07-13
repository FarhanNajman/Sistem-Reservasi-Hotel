<?php

namespace Tests\Feature;

use App\Models\Room;
use Tests\TestCase;

class RoomFloorTest extends TestCase
{
    public function test_room_number_is_prefixed_with_selected_floor(): void
    {
        $this->assertSame('101', Room::normalizeNomorKamar(1, '101'));
        $this->assertSame('205', Room::normalizeNomorKamar(2, '05'));
        $this->assertSame('301', Room::normalizeNomorKamar(3, '1'));
    }
}
