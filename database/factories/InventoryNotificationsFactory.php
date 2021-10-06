<?php

namespace Database\Factories;

use App\Models\InventoryItems;
use App\Models\InventoryNotifications;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryNotificationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InventoryNotifications::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type'=>$this->faker->randomElement(['out_of_stock','expire_soon','expired']),
            'inventory_item_id'=>InventoryItems::factory()->create()
        ];
    }
}
