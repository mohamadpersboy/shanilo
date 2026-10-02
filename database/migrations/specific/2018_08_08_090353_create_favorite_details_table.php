<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoriteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('favorite_id');
            $table->unsignedInteger('product_detail_id');
            $table->timestamps();

            $table->foreign('favorite_id')
                ->references('id')
                ->on('favorites')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('product_detail_id')
                ->references('id')
                ->on('product_details')
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
        Schema::dropIfExists('favorite_details');
    }
}
