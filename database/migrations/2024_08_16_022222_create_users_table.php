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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Client_Id', 225)->unique('Client_id');
            $table->string('branch_id', 200);
            $table->string('Emp_Id', 200);
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('gender', 225)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('username')->nullable()->unique('username');
            $table->string('role', 50)->nullable();
            $table->string('mobile_no', 250)->nullable()->unique('mobile_no');
            $table->date('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('Status', 250);
            $table->string('profile_image', 250);
            $table->rememberToken();
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
};
