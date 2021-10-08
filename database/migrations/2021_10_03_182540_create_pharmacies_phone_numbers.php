<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaciesPhoneNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacies_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number',14);
            $table->foreignId('pharmacy_branch_id')->constrained('pharmacy_branches')->onDelete('cascade')->onUpdate('cascade');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacies_phone_numbers');
    }
}
