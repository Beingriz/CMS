<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCyberWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cyber_work', function (Blueprint $table) {
            $table->string('COL 1', 5)->nullable();
            $table->string('COL 2', 12)->nullable();
            $table->string('COL 3', 13)->nullable();
            $table->string('COL 4', 27)->nullable();
            $table->string('COL 5', 10)->nullable();
            $table->string('COL 6', 11)->nullable();
            $table->string('COL 7', 25)->nullable();
            $table->string('COL 8', 16)->nullable();
            $table->string('COL 9', 12)->nullable();
            $table->string('COL 10', 12)->nullable();
            $table->string('COL 11', 11)->nullable();
            $table->string('COL 12', 7)->nullable();
            $table->string('COL 13', 12)->nullable();
            $table->string('COL 14', 23)->nullable();
            $table->string('COL 15', 49)->nullable();
            $table->string('COL 16', 73)->nullable();
            $table->string('COL 17', 14)->nullable();
            $table->string('COL 18', 11)->nullable();
            $table->string('COL 19', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cyber_work');
    }
}
