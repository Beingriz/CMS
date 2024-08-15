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
        Schema::create('applynow', function (Blueprint $table) {
            $table->string('Id', 225)->primary();
            $table->string('Client_Id', 225)->default('Not Available');
            $table->string('Branch_Id', 200)->default('BR1722167739');
            $table->string('Emp_Id', 200)->default('DC1684825596');
            $table->string('Application', 225);
            $table->string('Application_Type', 225);
            $table->string('Name', 225);
            $table->string('App_MobileNo', 225);
            $table->string('Mobile_No', 225);
            $table->string('Relative_Name', 225);
            $table->date('Dob')->nullable();
            $table->string('Message', 1000)->nullable();
            $table->string('File', 500)->nullable();
            $table->string('Consent', 1000);
            $table->string('Status', 225)->default('Submitted');
            $table->string('Reason', 200)->nullable()->default('Not Available');
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
        Schema::dropIfExists('applynow');
    }
};
