<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('category')->constrained('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('company_id');
            // $table->foreignId('company')->constrained('companies')->onUpdate('cascade');

            $table->string('name');
            $table->string('barcode')->nullable();
            $table->string('unit');
            $table->string('ingredient')->nullable();
            $table->string('photo')->nullable();

            $table->text('description')->nullable();
            $table->text('usage_instructions')->nullable();
            $table->text('warnings')->nullable();
            $table->text('side_effects')->nullable();

            $table->boolean('need_prescription')->default(false);
            // $table->timestamps();
        });
        /**Foreign Keys Constraints */
        Schema::table('products', function(Blueprint $table){
            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade');

            $table->foreign('company_id')
            ->references('id')
            ->on('companies')
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
        Schema::dropIfExists('products');
    }
}
