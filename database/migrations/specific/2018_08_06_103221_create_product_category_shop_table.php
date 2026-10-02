<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category_shop', function (Blueprint $table) {
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('product_category_id');

            $table->foreign('shop_id')
                ->references('id')
                ->on('shops')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')
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
        Schema::dropIfExists('product_category_shop');
    }
}
