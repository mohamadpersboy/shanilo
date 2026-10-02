<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('address_id');
            $table->unsignedInteger('send_type_id');
            $table->unsignedInteger('tax')->default(0);
            $table->unsignedInteger('total');
            $table->boolean('show_as_customer')->default(1);
            $table->unsignedInteger('transport_price');
            $table->boolean('seen')->default(0);
            $table->integer('status')
                ->default(1)
                ->comment('0:canceled ,1:order registered, 2:order confirmed, 3:contact between seller and customer, 4:sent, 5:received');
            $table->unsignedInteger('position')->default(1);
            $table->boolean('display')->default(1);
            $table->timestamps();

            $table->foreign('shop_id')
                ->references('id')
                ->on('shops')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('address_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('send_type_id')
                ->references('id')
                ->on('send_types')
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
        Schema::dropIfExists('orders');
    }
}
