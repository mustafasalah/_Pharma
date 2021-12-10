<?php

namespace Database\Seeders;

use App\Models\OrdersNotifications;
use Illuminate\Database\Seeder;

class OrdersNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            OrdersNotifications::factory()->times(100)->create();
        }catch(\Illuminate\Database\QueryException $ex){
            if(!($ex->getCode() === '22001')){
                throw $ex;
            }
        }
    }
}
