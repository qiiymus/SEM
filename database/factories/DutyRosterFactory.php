<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DutyRoster>
 */
class DutyRosterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->unique()->randomNumber(2),
            'user_name' => $this->faker->user_name(),
            'week' => $this->faker->week(),
            'date' => $this->faker->randomFloat(2, 0, 100),
            'status' => $this->faker->status(),
            'start_time' => $this->faker->randomNumber(2),
            'end_time' => $this->faker->randomNumber(2),
            // 'created_date' => $this->faker->word(),
            // 'updated_date' => $this->faker->word(),
            //
        ];
    }
}
