<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\fr_FR\Address;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Address($this->faker));
        return [
            'name' => $this->faker->name(),
            'departement' => $this->faker->departmentName(),
            'nik' => $this->faker->nik()            
        ];
    }
}
