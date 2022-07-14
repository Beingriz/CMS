<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_list', function (Blueprint $table) {
            $table->integer('Sl_No', 50);
            $table->string('Id', 50);
            $table->string('Name', 100);
            $table->string('Service_Type', 50);
            $table->string('Description', 2000);
            $table->string('Details', 2000)->nullable();
            $table->string('Features', 2000)->nullable();
            $table->string('Specification', 2000)->nullable();
            $table->string('Order_By', 50)->nullable();
            $table->integer('Total_Count')->default(0);
            $table->integer('Total_Amount')->default(0);
            $table->integer('Temp_Count')->nullable()->default(0);
            $table->string('Recycle_Bin', 50)->default('No');
            $table->string('Thumbnail', 250);
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
        Schema::dropIfExists('service_list');
    }
}
