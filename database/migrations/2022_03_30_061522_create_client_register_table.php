<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientRegisterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_register', function (Blueprint $table) {
            $table->string('Id', 50)->primary();
            $table->string('Name', 100);
            $table->string('Gender', 255)->nullable();;
            $table->date('DOB')->nullable();
            $table->string('Mobile_No', 200);
            $table->string('Email_Id', 50);
            $table->string('Address', 500);
            $table->string('Profile_Image', 250);
            $table->string('Client_Type', 50);
            $table->date('Registered_On')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_register');
    }
}
