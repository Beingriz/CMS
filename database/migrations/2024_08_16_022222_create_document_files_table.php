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
        Schema::create('document_files', function (Blueprint $table) {
            $table->string('Id', 50)->primary();
            $table->string('App_Id')->nullable();
            $table->string('Client_Id')->nullable();
            $table->string('Branch_Id', 200)->default('BR1722167739');
            $table->string('Emp_Id', 200)->default('DC168482559');
            $table->string('Document_Name')->nullable();
            $table->string('Document_Path')->nullable();
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
        Schema::dropIfExists('document_files');
    }
};
