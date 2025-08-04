<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Table;

class ReservationsTableSeeder extends Seeder
{
    public function run(): void
    {
//        $tableIds = Table::pluck('id')->toArray();
//
//        Reservation::factory(30)->create([
//            'table_id' => fn () => fake()->randomElement($tableIds),
//        ]);
    }
}
