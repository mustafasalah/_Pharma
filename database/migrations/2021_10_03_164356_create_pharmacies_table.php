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
            $table->foreignId("owner")->constrained("users");//id of the owner
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
        Schema::dropIfExists('pharmacies');
    }
}
