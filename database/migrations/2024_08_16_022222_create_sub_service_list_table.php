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
        Schema::create('sub_service_list', function (Blueprint $table) {
            $table->integer('Sl_No', true)->unique('Sl_No');
            $table->string('Service_Id', 50);
            $table->string('Id', 50)->primary();
            $table->string('Name', 250);
            $table->string('Service_Type', 50)->nullable();
            $table->string('Description', 500)->nullable();
            $table->integer('Unit_Price');
            $table->string('Service_Fee', 250)->nullable();
            $table->integer('Total_Count')->nullable();
            $table->integer('Total_Amount')->nullable();
            $table->text('Thumbnail')->nullable()->default('Not Available');
            $table->text('Recycle_Bin')->default('No');
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
        Schema::dropIfExists('sub_service_list');
    }
};
