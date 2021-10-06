<?php

namespace Database\Factories;

use App\Models\PharmaciesPhoneNumbers;
use App\Models\PharmacyBranches;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmaciesPhoneNumbersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PharmaciesPhoneNumbers::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'phone_number'=>$this->faker->numerify('+249##########'),
            'pharmacy_branch_id'=>PharmacyBranches::factory()->create()
        ];
    }
}
