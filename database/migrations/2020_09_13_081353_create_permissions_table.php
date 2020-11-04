<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('registro', ['users', 'users_types', 'species', 'schedules', 'special', 
            'pets', 'pet_details', 'permissions', 'medical_condition', 'appointment_types', 'appointment']);
            $table->boolean('create');
            $table->boolean('read');
            $table->boolean('update');
            $table->boolean('delete');
            $table->boolean('state')->default(1);
            $table->unsignedBigInteger('users_types_id');
            $table->foreign('users_types_id')->references('id')->on('users_types');
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
        Schema::dropIfExists('permissions');
    }
}
