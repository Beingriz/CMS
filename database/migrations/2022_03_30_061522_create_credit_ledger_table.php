<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditLedgerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_ledger', function (Blueprint $table) {
            $table->string('Id', 200)->primary();
            $table->string('Client_Id', 50);
            $table->date('Date');
            $table->string('Category', 50);
            $table->string('Sub_Category', 50);
            $table->double('Total_Amount');
            $table->double('Amount_Paid');
            $table->double('Balance');
            $table->string('Description', 500);
            $table->string('Payment_Mode', 50);
            $table->string('Attachment', 500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_ledger');
    }
}
