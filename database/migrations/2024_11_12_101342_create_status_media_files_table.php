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
        Schema::create('status_media_files', function (Blueprint $table) {
            $table->string('id',50)->primary();
            $table->string('service_id', 50); // Define as string with matching length
            $table->foreign('service_id') // Set up foreign key constraint manually
                    ->references('id')
                    ->on('services')
                    ->onDelete('cascade');
            $table->string('sub_service_id', 50); // Define as string with matching length
            $table->foreign('sub_service_id') // Set up foreign key constraint manually
                            ->references('id')
                            ->on('sub_services')
                            ->onDelete('cascade');
            $table->string('status_id', 50); // Define as string with matching length
            $table->foreign('status_id') // Set up foreign key constraint manually
                            ->references('id')
                            ->on('status')
                            ->onDelete('cascade');
            $table->string('file_path');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('status_media_files');
    }
};
