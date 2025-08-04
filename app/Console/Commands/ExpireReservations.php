<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpireReservations extends Command
{
    protected $signature = 'reservations:expire';
    protected $description = 'Mark reservations as expired after 3 hours if client didn’t show up';

    public function handle()
    {
        DB::transaction(function () {
            $expired = Reservation::where('status', 1)
                ->where('reserved_at', '<', now()->subHours(3))
                ->get();

            foreach ($expired as $reservation) {
                // Создать новую запись с новым статусом
                Reservation::create([
                    'table_id'     => $reservation->table_id,
                    'name'         => $reservation->name,
                    'phone'        => $reservation->phone,
                    'reserved_at'  => now(),
                    'status'       => 4, // Клиент не пришёл
                    'notes'        => $reservation->notes,
                ]);

                $reservation->table->update(['is_reserved' => false]);
            }
        });

        Log::info('End reservations:expire');
        $this->info('Expired reservations processed.');
    }
}
