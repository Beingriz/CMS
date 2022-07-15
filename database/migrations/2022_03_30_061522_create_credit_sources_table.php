<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_sources', function (Blueprint $table) {
            $table->string('Id', 50)->primary();
            $table->string('CS_Id', 50);
            $table->string('CS_Name', 200);
            $table->string('Source', 50);
            $table->integer('Unit_Price');
            $table->integer('Total_Revenue');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_sources');
    }
}
