<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Starship>
 */
class StarshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = \App\Models\Starship::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'model' => $this->faker->word(),
            'starship_class' => $this->faker->word(), 
            'manufacturer' => $this->faker->company(),
            'cost_in_credits' => $this->faker->randomNumber(5),
        ];
    }
}
