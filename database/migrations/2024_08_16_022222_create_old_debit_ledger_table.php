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
        Schema::create('old_debit_ledger', function (Blueprint $table) {
            $table->string('transaction_id', 300)->primary();
            $table->date('date');
            $table->string('particular', 50);
            $table->integer('amount');
            $table->string('description', 200);
            $table->string('payment_mode', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_debit_ledger');
    }
};
