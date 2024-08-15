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
        Schema::create('old_bookmarks', function (Blueprint $table) {
            $table->integer('sl_no', true);
            $table->string('bm_id', 50)->unique('bm_id');
            $table->string('name', 50);
            $table->string('hyperlink', 500);
            $table->string('status', 50)->default('Not Done');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_bookmarks');
    }
};
