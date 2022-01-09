<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_notifications', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('inventory_item_id')->constrained('inventory_items')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('inventory_item_id');

            $table->enum('type',['out_of_stock','expire_soon','expired']);
            $table->timestamps();
        });

        Schema::table('inventory_notifications', function (Blueprint $table){
            $table->foreign('inventory_item_id')->references('id')->on('inventory_items')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_notification');
    }
}
