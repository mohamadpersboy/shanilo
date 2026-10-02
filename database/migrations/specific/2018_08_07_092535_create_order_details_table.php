<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_detail_id');
            $table->unsignedInteger('price');
            $table->unsignedInteger('discount')->nullable()->default(0);
            $table->unsignedInteger('count')->default(1);
            $table->text('properties')->nullable();
            $table->unsignedInteger('position')->default(1);
            $table->boolean('display')->default(1);
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
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
        Schema::dropIfExists('order_details');
    }
}
