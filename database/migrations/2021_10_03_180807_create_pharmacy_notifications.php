<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmacyNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacy_notifications', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('pharmacy_branch_id')->constrained('pharmacy_branches')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('pharmacy_branch_id');
            $table->enum(
                'type',
                ['new_pharmacy', 'new_branch']
            );
            $table->timestamps();
        });
        /**Foreign Keys Constraints */
        Schema::table('pharmacy_notifications', function (Blueprint $table){
            $table->foreign('pharmacy_branch_id')
            ->references('id')
            ->on('pharmacy_branches')
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
        Schema::dropIfExists('pharmacy_notifications');
    }
}
