<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime("appointment_date",0);
            $table->enum('status', ['Activo', 'Fallecido', 'Casi terminada', 'Emergenecia']);
            $table->string('observations', 1000);
            $table->boolean('emergency')->default(0);;
            $table->boolean('state')->default(1);
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('appointment_types');
            $table->unsignedBigInteger('pet_id');
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');
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
        Schema::dropIfExists('appointments');
    }
}
