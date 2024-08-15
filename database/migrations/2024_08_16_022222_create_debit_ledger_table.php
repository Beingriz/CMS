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
        Schema::create('debit_ledger', function (Blueprint $table) {
            $table->string('Id', 200)->primary();
            $table->string('Client_Id', 50);
            $table->string('Branch_Id', 200)->default('BR1722167739');
            $table->string('Emp_Id', 200)->default('DC1684825596');
            $table->date('Date');
            $table->string('Category', 50);
            $table->string('Source', 100);
            $table->string('Name', 50);
            $table->integer('Unit_Price')->default(0);
            $table->integer('Quantity')->default(0);
            $table->double('Total_Amount');
            $table->double('Amount_Paid');
            $table->double('Balance');
            $table->string('Description', 500);
            $table->string('Payment_Mode', 50);
            $table->string('Attachment', 500)->nullable();
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
        Schema::dropIfExists('debit_ledger');
    }
};
