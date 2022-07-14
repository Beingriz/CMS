<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->string('ST_Id', 100)->primary();
            $table->string('Orderby', 50);
            $table->string('Status', 100);
            $table->integer('Total_Count')->default(0);
            $table->string('Relation', 50);
            $table->integer('Total_Amount')->default(0);
            $table->integer('Temp_Count')->default(0);
            $table->string('Thumbnail', 250);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status');
    }
}
