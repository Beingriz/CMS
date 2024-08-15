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
        Schema::create('debit_source', function (Blueprint $table) {
            $table->integer('Sl_No', true)->unique('Sl_No');
            $table->string('Id', 50)->primary();
            $table->string('Name', 100);
            $table->string('Category', 50)->default('Expenses');
            $table->string('Thumbnail', 200);
            $table->timestamp('updated_at')->useCurrent();
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
        Schema::dropIfExists('debit_source');
    }
};
