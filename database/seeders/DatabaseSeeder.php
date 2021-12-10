<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ViewsSeeder::class);
        $this->call(OrdersProductsSeeder::class);
        $this->call(OrdersNotificationsSeeder::class);
        $this->call(InventoryItemsNotificationsSeeder::class);
        $this->call(PharmacyPhoneNumbersSeeder::class);
        $this->call(PharmacyNotificationsSeeder::class);
    }
}
