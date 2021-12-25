<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_notifications', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('order_id')->constrained('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('order_id');

            $table->enum('type',['order']);
            $table->timestamps();
        });

        Schema::table('orders_notifications', function(Blueprint $table){

            $table->foreign('order_id')->references('id')->on('orders');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_notifications');
    }
}
