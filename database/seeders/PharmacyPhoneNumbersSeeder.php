<?php

namespace Database\Seeders;

use App\Models\PharmaciesPhoneNumbers;
use Illuminate\Database\Seeder;

class PharmacyPhoneNumbersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PharmaciesPhoneNumbers::factory()->times(50)->create();
    }
}
