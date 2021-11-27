<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\ProductRequest;

class ProductRequestListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::all()->random()->id,
            'product_request_id' => ProductRequest::all()->random()->id,
            'quantity' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->sentence(),
        ];
    }
}
