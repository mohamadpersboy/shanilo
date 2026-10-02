<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendTypeShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_type_shop', function (Blueprint $table) {
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('send_type_id');
            $table->timestamps();

            $table->foreign('shop_id')
                ->references('id')
                ->on('shops')
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
        Schema::dropIfExists('send_type_shop');
    }
}
