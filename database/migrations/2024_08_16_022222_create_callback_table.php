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
        Schema::create('callback', function (Blueprint $table) {
            $table->string('Id', 225)->primary();
            $table->string('Client_Id', 225);
            $table->string('Branch_Id', 200)->default('BR1722167739');
            $table->string('Name', 225);
            $table->string('Mobile_No', 225);
            $table->string('Username', 225)->nullable();
            $table->string('Service', 225);
            $table->string('Service_Type', 225);
            $table->string('Status', 250)->default('Pending');
            $table->string('Message', 250)->default('Please Call Customer');
            $table->string('Profile_Image', 250)->default('no_image.jpg');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('callback');
    }
};
