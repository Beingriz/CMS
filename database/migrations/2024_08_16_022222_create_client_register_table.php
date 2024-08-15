<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('Branch_Id', 200)->default('BR1722167739');
            $table->string('Emp_Id', 200)->default('DC1684825596');
            $table->string('Name', 100)->nullable();
            $table->string('Relative_Name')->nullable();
            $table->string('Gender')->nullable();
            $table->date('DOB')->nullable();
            $table->string('Mobile_No', 200)->nullable();
            $table->string('Email_Id', 50)->nullable();
            $table->string('Address', 500)->nullable();
            $table->text('Profile_Image')->default('Not Available');
            $table->string('Client_Type', 50)->nullable();
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
        Schema::dropIfExists('client_register');
    }
};
