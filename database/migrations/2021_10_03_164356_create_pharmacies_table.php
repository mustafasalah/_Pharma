<?php
/**
 * created by OX
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //creating the Pharmacies table
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger("owner_id");//id of the owner_id when the user is deleted the pharmacy is deleted
            // $table->timestamps();
        });
        /**Foreign Keys Constraints */
        Schema::table('pharmacies', function (Blueprint $table){
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacies');
    }
}
