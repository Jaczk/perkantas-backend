<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' =>$this->faker->numberBetween(1, 10),
            'return_date' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'due_date' => $this->faker->dateTimeBetween('now', '+4 weeks'),
            'period' => $this->faker->date('Ym'),
            'is_returned' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
