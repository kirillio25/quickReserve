<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Table;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use App\Services\Admin\TableClosedService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TableClosedServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TableClosedService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(); // Для статусов
        $this->service = new TableClosedService();
    }

    public function test_it_closes_reservation_and_marks_table_free(): void
    {
        $table = Table::factory()->create(['is_reserved' => true]);

        $reservation = Reservation::factory()->create([
            'table_id' => $table->id,
            'status' => 1, // Забронирован
        ]);

        $this->service->close($table);

        $this->assertDatabaseHas('reservations', [
            'table_id' => $table->id,
            'name' => $reservation->name,
            'status' => 5, // Посещение состоялось
        ]);

        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'is_reserved' => false,
        ]);
    }

    public function test_it_cancels_reservation_and_marks_table_free(): void
    {
        $table = Table::factory()->create(['is_reserved' => true]);

        $reservation = Reservation::factory()->create([
            'table_id' => $table->id,
            'status' => 1,
        ]);

        $this->service->cancel($table);

        $this->assertDatabaseHas('reservations', [
            'table_id' => $table->id,
            'name' => $reservation->name,
            'status' => 3, // Отменено
        ]);

        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'is_reserved' => false,
        ]);
    }

    public function test_it_does_nothing_if_no_reservations_exist(): void
    {
        $table = Table::factory()->create(['is_reserved' => true]);

        $this->service->close($table);

        // Проверим, что не было создано дополнительных резервов
        $this->assertDatabaseMissing('reservations', [
            'table_id' => $table->id,
            'status' => 5,
        ]);

        // Стол всё ещё забронирован
        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'is_reserved' => true,
        ]);
    }
}
