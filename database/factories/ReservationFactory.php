<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        return [
            'table_id' => null, // передаётся извне
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'reserved_at' => now()->addDays($this->faker->numberBetween(-3, 3))->addHours($this->faker->numberBetween(0, 23)),
            'status' => $this->faker->numberBetween(1, 5),
            'notes' => $this->faker->boolean(50) ? $this->faker->sentence() : null,
        ];
    }
}
