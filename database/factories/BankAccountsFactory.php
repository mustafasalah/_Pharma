<?php

namespace Database\Factories;

use App\Models\BankAccounts;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankAccountsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BankAccounts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no'=>$this->faker->numberBetween(0,99999999999999999999),
            'account_owner_name'=>$this->faker->name(),
            'bank_branch_name'=>$this->faker->name()
        ];
    }
}
