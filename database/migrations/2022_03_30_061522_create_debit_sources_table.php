<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_sources', function (Blueprint $table) {
            $table->string('Id', 100)->primary();
            $table->string('DS_Id', 50);
            $table->string('DS_Name', 100);
            $table->string('Source', 200);
            $table->integer('Outstanding')->default(0);
            $table->integer('Paid')->default(0);
            $table->integer('Balance')->default(0);
            $table->integer('Total_Amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debit_sources');
    }
}
