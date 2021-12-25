<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            // $table->foreignId('supplier_id')->constrained('suppliers')->onUpdate('cascade');
            $table->unsignedBigInteger('supplier_id')->nullable();
            // $table->foreignId('pharmacy_branch_id')->constrained('pharmacy_branches')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('pharmacy_branch_id');

            $table->unsignedInteger('stock');
            $table->unsignedInteger('reserved')->default(0);
            $table->float('price');
            $table->float('cost');

            $table->boolean("online_order")->default(true);

            $table->timestamp('arrival_date')->useCurrent();
            $table->timestamp('expire_date')->useCurrent();
            // $table->timestamps();
        });

        /**Foreign Keys Constraints */
        Schema::table('inventory_items', function(Blueprint $table){
            $table->foreign('product_id')->references('id')->on('products')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('supplier_id')->references('id')->on('suppliers')
            ->onDelete('set null');

            $table->foreign('pharmacy_branch_id')->references('id')->on('pharmacy_branches')
            ->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
}
