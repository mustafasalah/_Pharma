<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['local','online']);
            $table->enum('status',['finished','waiting','payment_confrimed','rejected']);
            $table->enum('payment_method',['MBOK','ATM Card','Cash']);
            $table->unsignedInteger('products_amount');
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('vat')->default(0);
            $table->foreignId('handeled_by')->constrained('employees');
            $table->timestamp('created_at');
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('pharmacy_branch_id')->constrained('pharmacy_branches');
            $table->foreignId('address_id')->constrained('addresses');
            $table->unsignedInteger('delivery')->default(0);
            $table->string('payment_proof_screenshot');
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
        Schema::dropIfExists('orders');
    }
}
