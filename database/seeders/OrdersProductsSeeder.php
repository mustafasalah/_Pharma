<?php

namespace Database\Seeders;

use App\Models\OrdersProducts;
use Illuminate\Database\Seeder;

class OrdersProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            OrdersProducts::factory()->times(100)->create();
        }catch(\Illuminate\Database\QueryException $ex){
            throw $ex;
        }
    }
}
