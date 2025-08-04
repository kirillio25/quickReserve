<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\ReservationStatus;
use Carbon\Carbon;

class ExpireReservationsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_expired_reservation_creates_new_with_status_4()
    {
        ReservationStatus::insert([
            ['id' => 1, 'name' => 'Забронирован'],
            ['id' => 4, 'name' => 'Просрочено'],
        ]);

        $table = Table::factory()->create(['is_reserved' => true]);

        $reservation = Reservation::factory()->create([
            'table_id'     => $table->id,
            'reserved_at'  => now()->subHours(4),
            'status'       => 1,
        ]);

        $this->artisan('reservations:expire')
            ->expectsOutput('Expired reservations processed.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('reservations', [
            'table_id' => $table->id,
            'status'   => 4,
        ]);

        $this->assertDatabaseHas('tables', [
            'id'           => $table->id,
            'is_reserved'  => false,
        ]);
    }

}
