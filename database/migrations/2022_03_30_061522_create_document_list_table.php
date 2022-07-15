<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_list', function (Blueprint $table) {
            $table->integer('Sl_No', true)->unique('Sl_No');
            $table->string('Id', 50)->primary();
            $table->string('Service_Id', 50);
            $table->string('Sub_Service_Id', 50);
            $table->string('Name', 50);
            $table->string('Type', 50)->default('Specific');
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_list');
    }
}
