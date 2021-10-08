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
            $table->foreignId("pharmacy_id")->constrained("pharmacies")->onDelete('cascade')->onUpdate('cascade');//cascade when the pharmacy is deleted or updated
            $table->string("name")->default('main branch');//set Default to the main branch if no other brach exist
            $table->string("email");
            $table->string("website")->nullable();
            $table->foreignId("address_id")->constrained("addresses")->onUpdate('cascade');//cascade when the address is updated and cant delete the address
            $table->enum("status",["pending","active","rejected"]);//the status of the branch
            $table->boolean("support_delivery")->default(false);
            $table->foreignId('atm_card')->constrained('atm_cards')->onUpdate('cascade');
            $table->foreignId('bank_account')->constrained('bank_accounts')->onUpdate('cascade');
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
