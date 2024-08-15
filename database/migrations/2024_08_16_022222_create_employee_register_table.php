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
        Schema::create('employee_register', function (Blueprint $table) {
            $table->string('Id', 200)->primary();
            $table->string('Emp_Id', 200);
            $table->string('Branch_Id', 200);
            $table->string('Branch', 200);
            $table->string('Username', 200)->nullable();
            $table->string('Password', 200)->nullable();
            $table->string('Name', 200);
            $table->date('DOB');
            $table->string('Mobile_No', 200);
            $table->string('Gender', 200);
            $table->string('Email_Id', 200);
            $table->string('Father_Name', 200);
            $table->string('Address', 200);
            $table->string('Qualification', 200);
            $table->string('Experience', 200);
            $table->string('Role', 200);
            $table->string('Profile_Img', 200)->nullable();
            $table->string('Qualification_Doc', 200)->nullable();
            $table->string('Resume_Doc', 200)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_register');
    }
};
