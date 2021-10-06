<?php

namespace Database\Factories;

use App\Models\Orders;
use App\Models\OrdersProducts;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrdersProducts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id'=>Products::factory()->create(),
            'order_id'=>Orders::factory()->create(),
            'quantity'=>$this->faker->randomDigit(),
            'price'=>$this->faker->numberBetween(0,12345),
            'cost'=>$this->faker->numberBetween(0,12345)
        ];
    }
}
