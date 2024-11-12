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
        Schema::create('status', function (Blueprint $table) {
            $table->string('id',50)->primary();
            $table->string('status_name', 100);
            $table->integer('order_by')->nullable();
            $table->integer('total_count')->nullable();
            $table->string('relation', 50)->nullable();
            $table->string('class')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('temp_count')->nullable();
            $table->text('thumbnail_path')->nullable();
            $table->timestamps();
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
};
