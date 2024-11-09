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
            $table->string('template_sid')->unique();  // Unique identifier for the template
            $table->string('template_name');  // Name of the template
            $table->string('lang');  // Language of the template (e.g., English, Spanish)
            $table->enum('category', ['utility', 'marketing', 'transactional']);  // Category of the template
            $table->enum('content_type', [
                'twilio/text',
                'twilio/media',
                'twilio/location',
                'twilio/list-picker',
                'twilio/call-to-action',
                'twilio/quick-reply',
                'twilio/card',
                'twilio/carousel',
                'twilio/catalog',
                'whatsapp/card',
                'whatsapp/authentication'
            ]);  // Type of the template content (based on Twilio's supported types)
            $table->json('variables');  // JSON field to store the template variables (e.g., placeholders like {{1}}, {{2}}, etc.)
            $table->text('body');  // The body content of the template (message body, HTML, etc.)
            $table->string('media_url')->nullable();  // URL for media (if the template contains media)
            $table->enum('status', ['pending', 'approved', 'rejected']);  // Approval status of the template (based on WhatsApp or Twilio's approval)
            $table->unsignedInteger('use_count')->default(0);  // Counter for how many times the template has been used
            $table->timestamp('last_created_at')->nullable(); // Last updated timestamp
            $table->timestamp('last_updated_at')->nullable(); // Last updated timestamp
            $table->timestamps();  // Created at and updated at timestamps
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
