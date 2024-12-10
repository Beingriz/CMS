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
        Schema::create('status_media', function (Blueprint $table) {
            $table->string('id'); // Unique identifier for each entry
            $table->string('service'); // Name of the service (e.g., "PAN Card", "Passport")
            $table->string('service_type'); // Type of service (e.g., "New", "Update", "Renewal")
            $table->string('status'); // Status of the service (e.g., "Active", "Inactive", "Pending")
            $table->text('media'); // URL or path to the media file
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_media');
    }
};
