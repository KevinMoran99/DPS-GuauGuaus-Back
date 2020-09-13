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
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('lastname', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 50);
            $table->char('dui', 10)->unique();
            $table->string('address', 500);
            $table->char('phone', 8);
            $table->boolean('state')->default(1);
            $table->unsignedBigInteger('type_user_id');
            $table->foreign('type_user_id')->references('id')->on('users_types');
            $table->timestamps();
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
