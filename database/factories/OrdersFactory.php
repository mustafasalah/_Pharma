<?php

namespace Database\Factories;

use App\Models\Addresses;
use App\Models\Employees;
use App\Models\Orders;
use App\Models\PharmacyBranches;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Orders::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type'=>$this->faker->randomElement(['local','online']),
            'status'=>$this->faker->randomElement(['finished','waiting','payment_confrimed','rejected']),
            'payment_method'=>$this->faker->randomElement(['MBOK','ATM Card','Cash']),
            'products_amount'=>$this->faker->numberBetween(0,234412),
            'vat'=>$this->faker->numberBetween(0,441223),
            'handeled_by'=>Employees::factory()->create(),
            'created_at'=>$this->faker->dateTime(),
            'users_id'=>User::factory()->create(),
            'pharmacy_branch_id'=>PharmacyBranches::factory()->create(),
            'address_id'=>Addresses::factory()->create(),
            'payment_proof_screenshot'=>$this->faker->sentence()
        ];
    }
}
