<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cart_id');
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('address_id')->nullable();
            $table->unsignedInteger('send_type_id')->nullable();
            $table->unsignedInteger('pay_type_id')->nullable();
            $table->boolean('show_as_customer')->default(1);
            $table->unsignedInteger('transport_price')->default(0);
            $table->timestamps();

            $table->foreign('cart_id')
                ->references('id')
                ->on('carts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //
            $table->foreign('shop_id')
                ->references('id')
                ->on('shops')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('set null')
                ->onUpdate('cascade');
            //
            $table->foreign('send_type_id')
                ->references('id')
                ->on('send_types')
                ->onDelete('set null')
                ->onUpdate('cascade');
            //
            $table->foreign('pay_type_id')
                ->references('id')
                ->on('pay_types')
                ->onDelete('set null')
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
        Schema::dropIfExists('cart_details');
    }
}
