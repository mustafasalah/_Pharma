<?php

namespace Database\Factories;

use App\Models\Orders;
use App\Models\OrdersNotifications;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersNotificationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrdersNotifications::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id'=>Orders::factory()->create()
        ];
    }
}
