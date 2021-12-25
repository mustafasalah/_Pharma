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
            // $table->foreignId("pharmacy_id")->constrained("pharmacies")->onDelete('cascade')->onUpdate('cascade');//cascade when the pharmacy is deleted or updated
            $table->unsignedBigInteger('pharmacy_id');
            // $table->foreignId("address_id")->constrained("addresses")->onUpdate('cascade');//cascade when the address is updated and cant delete the address
            $table->unsignedBigInteger('address_id');
            // $table->foreignId('atm_card')->constrained('atm_cards')->onUpdate('cascade');
            $table->unsignedBigInteger('atm_card_id')->nullable();
            // $table->foreignId('bank_account')->constrained('bank_accounts')->onUpdate('cascade');
            $table->unsignedBigInteger('bank_account_id')->nullable();

            $table->string("name")->default('');//set Default to the main branch if no other brach exist
            $table->string("email");
            $table->string("website")->nullable();
            $table->boolean("support_delivery")->default(false);

            $table->enum(
                "status",
                ["pending", "active", "rejected"]
                )->default('pending');//the status of the branch

                $table->timestamp("created_at");
        });

        /**Foreign Keys Constraints */
        Schema::table('pharmacy_branches', function (Blueprint $table){
            $table->foreign('pharmacy_id')
            ->references('id')
            ->on('pharmacies')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('address_id')
            ->references('id')
            ->on('addresses')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('atm_card_id')
            ->references('id')
            ->on('atm_cards')
            ->onDelete('set null');

            $table->foreign('bank_account_id')
            ->references('id')
            ->on('bank_accounts')
            ->onDelete('set null');
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
