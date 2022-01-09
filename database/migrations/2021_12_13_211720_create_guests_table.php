<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('address_id')->constrained('addresses')->onUpdate('cascade');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('order_id');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_number',14);
            $table->timestamp('last_seen')->useCurrent();
            $table->timestamp('create_time')->useCurrent();
        });

        Schema::table('guests', function(Blueprint $table){

            $table->foreign('address_id')->references('id')->on('addresses')
            ->onDelete('cascade');

            $table->foreign('order_id')->references('id')->on('orders')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guests');
    }
}
