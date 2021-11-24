<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('username',1000);
            $table->string('password');
            $table->enum('role',['pharmacist','branch_manager']);
            $table->foreignId('pharmacy_branch_id')->constrained('pharmacy_branches')->onDelete('cascade')->onUpdate('cascade');
            $table->string('phone_number',14)->nullable();
            $table->enum('gender',['m','f']);
            $table->time('work_from')->nullable();
            $table->time('work_to')->nullable();
            $table->timestamp('last_seen')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('employees');
    }
}
