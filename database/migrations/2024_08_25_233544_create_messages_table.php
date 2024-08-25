<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('user'); // WhatsApp user (phone number)
            $table->text('body')->nullable(); // Message content
            $table->boolean('sent')->default(false); // Whether the message was sent by our app
            $table->boolean('read')->default(false); // Whether the message was read by the recipient
            $table->string('attachment_url')->nullable(); // URL for attachments (e.g., images)
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
