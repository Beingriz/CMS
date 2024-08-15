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
        Schema::create('old_credit_ledger', function (Blueprint $table) {
            $table->string('transaction_id', 200)->primary();
            $table->date('date');
            $table->string('perticular', 50);
            $table->double('amount');
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
        Schema::dropIfExists('old_credit_ledger');
    }
};
