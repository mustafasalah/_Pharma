<?php

namespace Database\Seeders;

use App\Models\PharmacyNotifications;
use Illuminate\Database\Seeder;

class PharmacyNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PharmacyNotifications::factory()->times(50)->create();
    }
}
