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
        Schema::create('services', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 100);
            $table->string('service_type', 50);
            $table->string('description', 2000);
            $table->text('details')->nullable(); // Optional JSON
            $table->text('features')->nullable(); // Optional JSON
            $table->text('specification')->nullable(); // Optional JSON
            $table->string('order_by', 50)->nullable();
            $table->integer('total_count')->default(0);
            $table->integer('total_amount')->default(0);
            $table->integer('temp_count')->nullable()->default(0);
            $table->text('thumbnail')->nullable();
            $table->text('image')->nullable(); // Changed to text for flexibility
            $table->boolean('recycle_bin')->default(false); // Changed to boolean
            $table->timestamps(); // Automatically handles created_at and updated_at
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
