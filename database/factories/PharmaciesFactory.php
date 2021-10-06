<?php

namespace Database\Factories;

use App\Models\Pharmacies;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmaciesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pharmacies::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name(),
            'owner'=>User::factory()->create()
        ];
    }
}
