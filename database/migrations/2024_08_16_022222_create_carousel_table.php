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
        Schema::create('carousel', function (Blueprint $table) {
            $table->string('Id', 225)->primary();
            $table->string('Tittle', 225);
            $table->string('Description', 225);
            $table->string('Service_Id', 225);
            $table->string('created_at', 225);
            $table->string('updated_at', 225);
            $table->string('Image', 225);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carousel');
    }
};
