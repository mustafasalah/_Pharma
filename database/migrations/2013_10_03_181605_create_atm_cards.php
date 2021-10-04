<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtmCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atm_cards', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->unsignedBigInteger('card_no');
            // $table->foreignId('pharmacy_branch_id')->constrained('pharmacy_branches');
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atm_cards');
    }
}
