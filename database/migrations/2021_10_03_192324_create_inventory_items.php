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
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->onUpdate('cascade');
            $table->foreignId('pharmacy_branch_id')->constrained('pharmacy_branches')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('price');
            $table->unsignedInteger('cost');
            $table->unsignedInteger('stock');
            $table->unsignedInteger('reserved')->default(0);
            $table->boolean("online_order")->default(true);
            $table->timestamp('arrival_date')->useCurrent();
            $table->timestamp('expire_date')->useCurrent();
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
        Schema::dropIfExists('inventory_items');
    }
}
