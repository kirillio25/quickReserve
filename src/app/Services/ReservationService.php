<?php

namespace App\Services;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function reserve(Table $table, array $data): void
    {
        DB::transaction(function () use ($table, $data) {
            $table->update(['is_reserved' => true]);

            Reservation::create([
                'table_id'    => $table->id,
                'name'        => $data['name'],
                'phone'       => $data['phone'],
                'notes'       => $data['notes'] ?? null,
                'reserved_at' => $data['reserved_at'],
                'status'      => $data['status'],
            ]);
        });
    }
}
