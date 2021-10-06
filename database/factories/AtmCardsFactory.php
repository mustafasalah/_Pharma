<?php

namespace Database\Factories;

use App\Models\AtmCards;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtmCardsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AtmCards::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bank_name'=>$this->faker->name(),
            'card_no'=>$this->faker->creditCardNumber()
        ];
    }
}
