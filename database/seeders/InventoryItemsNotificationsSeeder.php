<?php

namespace Database\Seeders;

use App\Models\InventoryNotifications;
use Illuminate\Database\Seeder;

class InventoryItemsNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InventoryNotifications::factory()->times(500)->create();
    }
}
