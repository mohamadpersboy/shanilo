<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('page_id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('icon')->nullable();
            $table->string('link')->nullable();
            $table->unsignedInteger('position')->default(1);
            $table->boolean('display')->default(1);
            $table->timestamps();

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_items');
    }
}
