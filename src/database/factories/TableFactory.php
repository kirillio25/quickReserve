<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    protected $model = Table::class;

    public function definition(): array
    {
        static $i = 1;

        return [
            'name' => 'Столик №' . $i++,
            'seats' => $this->faker->numberBetween(2, 8),
            'is_reserved' => false,
            //'is_reserved' => $this->faker->boolean(30),
            'location' => $this->faker->randomElement(['Зал 1', 'Зал 2', 'У окна', 'Балкон']),
        ];
    }
}
