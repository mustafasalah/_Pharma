<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_products', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('product_id')->constrained('products')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('order_id');

            $table->unsignedSmallInteger('quantity');
            $table->float('price');
            $table->float('cost');
            // $table->timestamps();
        });
        /** Foreign Keys Constraints */
        Schema::table('orders_products', function (Blueprint $table){

            $table->foreign('product_id')->references('id')->on('products');

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
        Schema::dropIfExists('orders_products');
    }
}
