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
        Schema::create('balance_ledger', function (Blueprint $table) {
            $table->string('Id', 50)->primary();
            $table->string('Client_Id', 50);
            $table->string('Branch_Id', 200)->default('BR1722167739');
            $table->string('Emp_Id', 200)->default('DC168482559');
            $table->date('Date')->nullable();
            $table->string('Name', 50);
            $table->string('Mobile_No', 250);
            $table->string('Category', 50);
            $table->string('Sub_Category', 50);
            $table->double('Total_Amount');
            $table->double('Amount_Paid');
            $table->double('Balance');
            $table->string('Payment_Mode', 50);
            $table->string('Attachment', 500)->nullable();
            $table->string('Description', 500);
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
        Schema::dropIfExists('balance_ledger');
    }
};
