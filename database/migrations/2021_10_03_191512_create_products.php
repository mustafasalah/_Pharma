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
            $table->string('name');
            $table->string('barcode')->nullable();
            $table->string('unit');
            $table->foreignId('category')->constrained('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('company')->constrained('companies')->onUpdate('cascade');
            $table->string('ingredient')->nullable();
            $table->boolean('need_prescreption')->default(false);
            $table->text('description')->nullable();
            $table->text('usage_instructions')->nullable();
            $table->text('warnings')->nullable();
            $table->text('side_effects')->nullable();
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('products');
    }
}
