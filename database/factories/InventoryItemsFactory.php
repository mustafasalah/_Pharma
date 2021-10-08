<?php

namespace Database\Factories;

use App\Models\InventoryItems;
use App\Models\PharmacyBranches;
use App\Models\Products;
use App\Models\Suppliers;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InventoryItems::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id'=>Products::factory()->create(),
            'supplier_id'=>Suppliers::factory()->create(),
            'pharmacy_branch_id'=>PharmacyBranches::factory()->create(),
            'price'=>$this->faker->numberBetween(0,2147412),
            'cost'=>$this->faker->numberBetween(0,374122),
            'stock'=>$this->faker->numberBetween(0,913442),
            'price'=>$this->faker->numberBetween(0,50),
            'arrival_date'=>$this->faker->dateTimeThisYear(),
            'expire_date'=>$this->faker->dateTimeThisYear()
        ];
    }
}
