<?php

namespace Database\Seeders;

use App\Models\Views;
use Illuminate\Database\Seeder;

class ViewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Views::factory()->times(100)->create();
    }
}
