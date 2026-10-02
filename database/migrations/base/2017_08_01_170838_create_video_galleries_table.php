<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',512);
            $table->text('description')->nullable();
            $table->unsignedInteger('position')->default(1);
            $table->boolean('display')->default(1);
            $table->unsignedInteger('hit')->default(0); // views
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
        Schema::dropIfExists('video_galleries');
    }
}
