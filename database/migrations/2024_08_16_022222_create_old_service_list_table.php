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
        Schema::create('old_service_list', function (Blueprint $table) {
            $table->integer('sl_no', true);
            $table->string('service_name', 200);
            $table->string('status', 225)->default('Not Done');
            $table->integer('total_amount');
            $table->integer('total_app');
            $table->string('thumbnail', 250);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_service_list');
    }
};
