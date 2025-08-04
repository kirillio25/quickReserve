<?php

namespace App\Services\Admin;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class TableClosedService
{
    public function close(Table $table): void
    {
        $this->markReservationComplete($table, 5);
    }

    public function cancel(Table $table): void
    {
        $this->markReservationComplete($table, 3);
    }

    private function markReservationComplete(Table $table, int $status): void
    {
        DB::transaction(function () use ($table, $status) {
            $lastReservation = Reservation::where('table_id', $table->id)
                ->latest('reserved_at')
                ->first();

            if (!$lastReservation) {
                return;
            }

            Reservation::create([
                'table_id'    => $lastReservation->table_id,
                'name'        => $lastReservation->name,
                'phone'       => $lastReservation->phone,
                'reserved_at' => now(),
                'status'      => $status,
                'notes'       => $lastReservation->notes,
            ]);

            $table->update(['is_reserved' => false]);
        });
    }
}
