<?php

namespace Database\Factories;

use App\Models\PharmacyBranches;
use App\Models\PharmacyNotifications;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacyNotificationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PharmacyNotifications::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type'=>$this->faker->randomElement(['new_pharmacy','new_branch']),
            'pharmacy_branch_id'=>PharmacyBranches::factory()->create()
        ];
    }
}
