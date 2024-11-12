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
        Schema::create('sub_services', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('service_id', 50); // Define as string with matching length
            $table->foreign('service_id') // Set up foreign key constraint manually
                    ->references('id')
                    ->on('services')
                    ->onDelete('cascade');
            $table->string('name', 250);
            $table->string('service_type', 50)->nullable();
            $table->text('description')->nullable();
            $table->integer('unit_price');
            $table->decimal('service_fee', 10, 2)->nullable();
            $table->integer('total_count')->nullable();
            $table->integer('total_amount')->nullable();
            $table->text('thumbnail')->nullable();
            $table->boolean('recycle_bin')->default(false);
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
        Schema::dropIfExists('sub_services');
    }
};
