<?php
/**
 * created by OX
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmacyBranches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //creating the Pharmacy Branches table
        Schema::create('pharmacy_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId("pharmacy_id")->constrained("pharmacies");
            $table->string("name")->default('main branch');//set Default to the main branch if no other brach exist
            $table->string("email");
            $table->string("website")->nullable();
            $table->foreignId("address")->constrained("addresses");
            $table->enum("status",["pending","active","rejected"]);//the status of the branch
            $table->boolean("support_delivery")->default(false);
            $table->foreignId('atm_card')->constrained('atm_cards');
            $table->foreignId('bank_account')->constrained('bank_accounts');
            $table->timestamp("created_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacy_branches');
    }
}
