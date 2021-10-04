<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username',20)->unique();
            $table->string('password');
            $table->enum('gender',['m','f']);
            $table->string('email')->unique();
            $table->string('phone_number',14);
            $table->foreignId('address')->constrained('addresses');
            $table->enum('role',['admin','pharmacy_owner','user'])->default('user');
            $table->enum('status',['activated','non-activated','banned']);
            $table->timestamp('last_seen')->useCurrent();
            $table->timestamp('create_time')->useCurrent();
            //$table->rememberToken();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
