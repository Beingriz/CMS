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
        Schema::create('debit_sources', function (Blueprint $table) {
            $table->string('Id', 100)->primary();
            $table->string('DS_Id', 50);
            $table->string('DS_Name', 100);
            $table->string('Name', 200);
            $table->integer('Unit_Price')->default(0);
            $table->integer('Quantity')->default(0);
            $table->integer('Total_Paid')->default(0);
            $table->integer('Tenure')->default(0);
            $table->integer('Remaining')->default(0);
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
        Schema::dropIfExists('debit_sources');
    }
};
