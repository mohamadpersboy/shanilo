<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartDetailProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_detail_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cart_detail_id');
            $table->unsignedInteger('product_detail_id');
            $table->unsignedInteger('count')->default(1);
            $table->text('properties')->nullable();
            $table->timestamps();

            $table->foreign('cart_detail_id')
                ->references('id')
                ->on('cart_details')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //
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
        Schema::dropIfExists('cart_detail_products');
    }
}
