<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',512);
            $table->string('source',512)->nullable();
            $table->string('link',512)->nullable();
            $table->text('description')->nullable();
            $table->text('summery')->nullable();
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
        Schema::connection('mysql')->dropIfExists('news');
    }
}
