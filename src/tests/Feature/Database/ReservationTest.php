<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Table;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use Carbon\Carbon;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_reservation(): void
    {
        $table = Table::factory()->create();
        $status = ReservationStatus::create(['name' => 'Забронирован']);

        $reservation = Reservation::create([
            'table_id' => $table->id,
            'name' => 'Иван',
            'phone' => '+77001234567',
            'reserved_at' => Carbon::now(),
            'status' => $status->id,
            'notes' => 'У окна',
        ]);

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'table_id' => $table->id,
            'name' => 'Иван',
            'phone' => '+77001234567',
            'status' => $status->id,
        ]);
    }
}
