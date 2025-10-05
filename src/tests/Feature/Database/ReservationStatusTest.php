<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ReservationStatus;

class ReservationStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_reservation_status(): void
    {
        $status = ReservationStatus::create(['name' => 'Забронирован']);

        $this->assertDatabaseHas('reservation_statuses', [
            'id' => $status->id,
            'name' => 'Забронирован',
        ]);
    }
}
