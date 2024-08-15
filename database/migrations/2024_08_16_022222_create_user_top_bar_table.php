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
        Schema::create('user_top_bar', function (Blueprint $table) {
            $table->string('Id', 225)->primary();
            $table->string('Selected', 50)->default('No');
            $table->string('Company_Name', 225);
            $table->string('Address', 225);
            $table->string('Phone_No', 225);
            $table->string('Email_Id', 225)->nullable()->default('Not Available');
            $table->string('Time_From', 225);
            $table->string('Time_To', 225);
            $table->string('Facebook', 225)->nullable();
            $table->string('Twitter', 225)->nullable();
            $table->string('LinkedIn', 225)->nullable();
            $table->string('Instagram', 225)->nullable();
            $table->string('Youtube', 225)->nullable();
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
        Schema::dropIfExists('user_top_bar');
    }
};
