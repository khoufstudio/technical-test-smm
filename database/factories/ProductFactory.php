<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_code' => $this->faker->postcode(),
            'name' => $this->faker->word(),
            'location' => $this->faker->randomElement(['Bandung', 'Jakarta', 'Denpasar']),
            'stock' => $this->faker->numberBetween(0, 100),
            'packaging' => $this->faker->randomElement(['Pak', 'Karton', 'Biji'])
        ];
    }
}
