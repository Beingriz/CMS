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
        Schema::create('credit_source', function (Blueprint $table) {
            $table->integer('Sl_No', true)->unique('Sl_No');
            $table->string('Id', 50)->primary();
            $table->string('Name', 100);
            $table->string('Thumbnail', 500)->default('no_image.jpg');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_source');
    }
};
