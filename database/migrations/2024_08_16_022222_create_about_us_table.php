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
        Schema::create('about_us', function (Blueprint $table) {
            $table->string('Id', 225);
            $table->string('Tittle', 225);
            $table->string('Description', 500);
            $table->string('Total_Clients', 225);
            $table->string('Image', 225);
            $table->string('Delivered', 225);
            $table->string('Selected', 50)->default('No');
            $table->string('created_at', 225);
            $table->string('updated_at', 225);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_us');
    }
};
