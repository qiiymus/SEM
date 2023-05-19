<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => $this->faker->unique()->randomNumber(2),
            'product_name' => $this->faker->name(),
            'product_cost' => $this->faker->randomFloat(2, 0, 100),
            'product_price' => $this->faker->randomFloat(2, 0, 100),
            'product_quantity' => $this->faker->randomNumber(2),
            'product_category' => $this->faker->randomElement(['food', 'stationary']),
            'product_brand' => $this->faker->word(),
        ];
    }
}
