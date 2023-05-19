<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total_price' => $this->faker->randomFloat(2, 0, 999.99),
            'payment_method' => $this->faker->randomElement(['Cash', 'QR']),
            'cash_amount' => $this->faker->randomFloat(2, 0, 999.99),
        ];
    }
}
