<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmark', function (Blueprint $table) {
            $table->integer('Sl_No', true);
            $table->string('BM_Id', 50)->unique('bm_id');
            $table->string('Name', 50);
            $table->string('Relation', 50);
            $table->string('Hyperlink', 500);
            $table->string('Thumbnail', 100);
            $table->timestamp('Updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookmark');
    }
}
