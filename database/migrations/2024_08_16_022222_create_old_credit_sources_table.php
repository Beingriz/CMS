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
        Schema::create('old_credit_sources', function (Blueprint $table) {
            $table->integer('sl_no', true);
            $table->string('particular', 50);
            $table->integer('total_amount');
            $table->string('Status', 50)->default('Not Done');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_credit_sources');
    }
};
