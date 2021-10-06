<?php

namespace Database\Factories;

use App\Models\Addresses;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Addresses::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'state'=>$this->faker->name(),
            'city'=>$this->faker->city(),
            'address'=>$this->faker->address(),
            'latitude'=>$this->faker->latitude(),
            'longitude'=>$this->faker->longitude()
        ];
    }
}
