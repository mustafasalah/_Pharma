<?php

namespace Database\Factories;

use App\Models\Addresses;
use App\Models\AtmCards;
use App\Models\BankAccounts;
use App\Models\Pharmacies;
use App\Models\PharmacyBranches;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacyBranchesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PharmacyBranches::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pharmacy_id'=>Pharmacies::factory()->create(),
            // 'name'=>$this->faker->name(),
            'email'=>$this->faker->unique()->safeEmail(),
            'address'=>Addresses::factory()->create(),
            'status'=>$this->faker->randomElement(["pending","active","rejected"]),
            'support_delivery'=>$this->faker->boolean(30),
            'atm_card'=>AtmCards::factory()->create(),
            'bank_account'=>BankAccounts::factory()->create(),
            'created_at'=>$this->faker->dateTime('now')
        ];
    }
}
