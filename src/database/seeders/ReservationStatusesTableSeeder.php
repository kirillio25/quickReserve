<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReservationStatus;

class ReservationStatusesTableSeeder extends Seeder
{
    public function run(): void
    {
        ReservationStatus::insert([
            ['name' => 'Забронирован'],
            ['name' => 'Клиент пришел, занято'],
            ['name' => 'Отменено пользователем или админом'],
            ['name' => 'Клиент не пришёл'],
            ['name' => 'Посещение состоялось, бронь закрыта'],
        ]);
    }
}
