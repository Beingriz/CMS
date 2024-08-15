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
        Schema::create('old_digital_cyber_db', function (Blueprint $table) {
            $table->integer('sl_no', true);
            $table->string('customer_id', 250)->unique('customer_id');
            $table->date('received_on');
            $table->string('customer_name', 200);
            $table->date('dob');
            $table->string('mobile_no', 200);
            $table->string('services', 200);
            $table->date('applied_on');
            $table->integer('total_amount');
            $table->integer('amount_paid');
            $table->integer('balance');
            $table->string('payment_mode', 200);
            $table->string('status', 100);
            $table->string('ack_no', 200);
            $table->string('document_no', 100);
            $table->date('delivered_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_digital_cyber_db');
    }
};
