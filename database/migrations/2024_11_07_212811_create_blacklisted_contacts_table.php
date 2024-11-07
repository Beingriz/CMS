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
        Schema::create('blacklisted_contacts', function (Blueprint $table) {
            $table->string('id');
            $table->string('client_id')->unique();
            $table->string('mobile_no'); // Mobile number of the blacklisted client
            $table->string('reason')->nullable(); // Optional reason for blacklisting
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
        Schema::dropIfExists('blacklisted_contacts');
    }
};
