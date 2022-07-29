<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubServiceListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_service_list', function (Blueprint $table) {
            $table->integer('Sl_No',  50);
            $table->string('Service_Id', 50);
            $table->string('Id', 50);
            $table->string('Name', 250)->nullable();;
            $table->string('Service_Type', 50)->nullable();
            $table->string('Description', 200)->nullable();
            $table->string('Unit_Price')->nullable();;
            $table->string('Service_Fee')->nullable();;
            $table->integer('Total_Count')->nullable();
            $table->integer('Total_Amount')->nullable();
            $table->string('Thumbnail', 250)->nullable();;
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
}
