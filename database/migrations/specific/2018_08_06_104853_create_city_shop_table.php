<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_shop', function (Blueprint $table) {
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('shop_id');
            $table->integer('price')->default(0);

            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('shop_id')
                ->references('id')
                ->on('shops')
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
        Schema::dropIfExists('city_shop');
    }
}
