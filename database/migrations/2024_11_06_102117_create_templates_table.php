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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_name');  // Template name
            $table->string('content_template_sid')->unique(); // Content template SID
            $table->enum('template_language', ['English', 'Hindi', 'Spanish'])->default('English'); // Template language
            $table->text('template_body');  // Template body content
            $table->string('media_url')->nullable(); // Media URL for video or card
            $table->enum('whatsapp_approval_status', ['pending', 'approved', 'rejected'])->default('pending'); // WhatsApp approval status
            $table->enum('content_type', ['text', 'image', 'video', 'whatsapp_card'])->default('text'); // Content type
            $table->timestamp('last_updated_at')->nullable(); // Last updated timestamp
            $table->enum('whatsapp_category', ['utility', 'marketing', 'transactional'])->default('utility'); // WhatsApp category
            $table->enum('status', ['pending', 'approved'])->default('pending'); // Status
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
        Schema::dropIfExists('templates');
    }
};
