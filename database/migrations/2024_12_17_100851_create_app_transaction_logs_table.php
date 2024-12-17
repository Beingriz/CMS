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
        Schema::create('app_transaction_logs', function (Blueprint $table) {
            $table->string('id')->primary(); // String as the primary key
            $table->string('application_id', 250); // Reference to digital_cyber_db.Id
            $table->string('action'); // Created, Updated, Deleted
            $table->string('emp_id', 200)->nullable();
            $table->string('branch_id', 200)->nullable();
            // All Digital Cyber DB columns
            $table->string('name', 200)->nullable();
            $table->string('gender')->nullable();
            $table->string('relative_name', 50)->nullable();
            $table->date('dob')->nullable();
            $table->string('mobile_no', 200)->nullable();
            $table->string('application', 50)->nullable();
            $table->string('application_type', 200)->nullable();
            $table->date('received_date')->nullable();
            $table->date('applied_date')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('amount_paid')->nullable();
            $table->integer('balance')->nullable();
            $table->string('payment_mode', 200)->nullable();
            $table->string('payment_receipt')->nullable();
            $table->string('status', 100)->nullable();
            $table->string('reason', 200)->nullable();
            $table->string('ack_no', 200)->nullable();
            $table->string('ack_file', 250)->nullable();
            $table->string('document_no', 100)->nullable();
            $table->string('doc_file', 250)->nullable();
            $table->string('total_doc_uploaded', 500)->nullable();
            $table->string('applicant_Image', 250)->nullable();
            $table->date('delivered_date')->nullable();
            $table->string('message', 500)->nullable();
            $table->string('consent', 1500)->nullable();
            $table->string('recycle_Bin', 50)->nullable();
            $table->string('registered', 50)->nullable();
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
        Schema::dropIfExists('app_transaction_logs');
    }
};
