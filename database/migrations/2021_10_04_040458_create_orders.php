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

            // $table->foreignId('employee_id')->constrained('employees');
            // $table->foreignId('users_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreignId('pharmacy_branch_id')->constrained('pharmacy_branches')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreignId('address_id')->constrained('addresses')->onUpdate('cascade');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('pharmacy_branch_id');
            $table->unsignedBigInteger('address_id')->nullable();

            $table->unsignedInteger('products_amount');
            $table->float('discount')->default(0);
            $table->float('vat')->default(0);
            $table->float('delivery')->default(0);

            $table->string('payment_proof_screenshot')->nullable();

            $table->enum(
                'type',
                ['local','online']
            );
            $table->enum(
                'status',
                ['finished','waiting','payment_confirmed','rejected']
            );
            $table->enum(
                'payment_method',
                ['MBOK','ATM Card','Cash']
            );

            $table->timestamp('created_at');
            // $table->timestamps();
        });

        /**Foreign Keys Constraints */
        Schema::table('orders', function(Blueprint $table){
            $table->foreign('employee_id')->references('id')->on('employees');

            $table->foreign('user_id')->references('id')->on('users');

            $table->foreign('pharmacy_branch_id')->references('id')->on('pharmacy_branches');

            $table->foreign('address_id')->references('id')->on('addresses');
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
