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
        Schema::create('digital_cyber_db', function (Blueprint $table) {
            $table->string('Id', 250)->primary();
            $table->string('Client_Id', 50);
            $table->string('Branch_Id', 200)->default('BR1722167739');
            $table->string('Emp_Id', 200)->default('DC1684825596');
            $table->date('Received_Date')->nullable();
            $table->string('Name', 200);
            $table->string('Gender')->nullable();
            $table->string('Relative_Name', 50)->nullable();
            $table->date('Dob')->nullable();
            $table->string('Mobile_No', 200);
            $table->string('Application', 50);
            $table->string('Application_Type', 200);
            $table->date('Applied_Date')->nullable();
            $table->integer('Total_Amount')->nullable();
            $table->integer('Amount_Paid')->nullable();
            $table->integer('Balance')->nullable();
            $table->string('Payment_Mode', 200)->nullable();
            $table->string('Payment_Receipt')->default('Not Available');
            $table->string('Status', 100);
            $table->string('Reason', 200)->nullable()->default('Not Available');
            $table->string('Ack_No', 200)->nullable();
            $table->string('Ack_File', 250)->default('Not Available');
            $table->string('Document_No', 100)->nullable();
            $table->string('Doc_File', 250)->default('Not Available');
            $table->string('Applicant_Image', 250)->default('Not Available');
            $table->date('Delivered_Date')->nullable();
            $table->string('Message', 500)->default('No Message Available from User');
            $table->string('Consent', 1500)->nullable();
            $table->string('Recycle_Bin', 50)->nullable()->default('No');
            $table->string('Registered', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->unique(['Id'], 'customer_id');
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
};
