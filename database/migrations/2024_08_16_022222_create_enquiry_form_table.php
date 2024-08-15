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
        Schema::create('enquiry_form', function (Blueprint $table) {
            $table->string('Id', 225)->primary();
            $table->string('Branch_Id', 200)->default('BR1722167739');
            $table->string('Name', 225);
            $table->string('Phone_No', 225);
            $table->string('Email', 225);
            $table->string('Service', 225);
            $table->string('Service_Type', 500)->nullable();
            $table->string('Message', 500)->default('Not Available');
            $table->string('Status', 50)->default('Pending');
            $table->string('Feedback', 500)->default('Not Available');
            $table->string('Conversion', 50)->default('No');
            $table->string('Lead_Status', 500)->default('Hot');
            $table->string('Amount', 225)->nullable();
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
        Schema::dropIfExists('enquiry_form');
    }
};
