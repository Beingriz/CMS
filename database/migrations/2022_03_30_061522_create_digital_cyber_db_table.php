<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalCyberDbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_cyber_db', function (Blueprint $table) {
            $table->string('Id', 250)->unique('customer_id');
            $table->string('Client_Id', 50);
            $table->date('Received_Date');
            $table->string('Name', 200);
            $table->string('Gender', 255)->nullable();
            $table->string('Relative_Name', 50)->nullable();
            $table->date('Dob');
            $table->string('Mobile_No', 200);
            $table->string('Application', 50);
            $table->string('Application_Type', 200);
            $table->date('Applied_Date')->nullable();
            $table->integer('Total_Amount');
            $table->integer('Amount_Paid');
            $table->integer('Balance');
            $table->string('Payment_Mode', 200);
            $table->string('Payment_Receipt', 2000)->default('Not Available');
            $table->string('Status', 100);
            $table->string('Ack_No', 200)->nullable();
            $table->string('Ack_File', 2000)->nullable()->default('Not Available');
            $table->string('Document_No', 100)->nullable();
            $table->string('Doc_File', 2000)->nullable()->default('Not Available');
            $table->date('Delivered_Date')->nullable();
            $table->string('Recycle_Bin', 50)->nullable()->default('No');
            $table->string('Registered', 50)->nullable()->default('No');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_cyber_db');
    }
}
