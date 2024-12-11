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
        Schema::create('template_media_manager', function (Blueprint $table) {
            $table->string('id')->primary(); // String as the primary key
            $table->string('sid')->unique(); // Unique identifier for the template
            $table->string('template_name'); // Template name
            $table->text('body'); // Template body
            $table->string('media_file')->nullable(); // Media file path or URL
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_media_manager');
    }
};
