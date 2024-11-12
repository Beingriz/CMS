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
        Schema::create('status', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('Orderby', 50);
            $table->string('Status', 100);
            $table->integer('Total_Count')->nullable();
            $table->string('Relation', 50);
            $table->string('Class')->nullable();
            $table->integer('Total_Amount')->nullable();
            $table->integer('Temp_Count')->nullable();
            $table->text('Thumbnail')->nullable();
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
        Schema::dropIfExists('status');
    }
};
