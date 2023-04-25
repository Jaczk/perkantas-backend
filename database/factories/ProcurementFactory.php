<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Procurement>
 */
class ProcurementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'goods_name' => $this->faker->words(),
            'goods_amount' => $this->faker->numberBetween(1, 20),
            'description' => $this->faker->text(),
            'period' => $this->faker->date('Ym'),
        ];
    }
}
