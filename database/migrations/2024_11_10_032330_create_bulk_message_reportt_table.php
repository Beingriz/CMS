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
        Schema::create('bulk_message_report', function (Blueprint $table) {
            $table->id();
            $table->string('template_sid');  // Foreign key referencing template_sid in templates table
            $table->string('service');
            $table->string('service_type');
            $table->integer('total_recipients');
            $table->integer('successful_sends');
            $table->integer('marketing_cost');
            $table->timestamps();

            // Set up the foreign key constraint to reference template_sid in the templates table
            $table->foreign('template_sid')
                  ->references('template_sid')
                  ->on('templates')
                  ->onDelete('cascade'); // Ensures related reports are deleted if the template is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulk_message_report');
    }
};
