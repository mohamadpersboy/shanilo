<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wallet_id');
            $table->unsignedInteger('bank_cart_id');
            $table->unsignedInteger('price');
            $table->enum('status', ['done', 'pending', 'denied'])->default('pending');
            $table->string('tracking_code')->nullable();
            $table->unsignedInteger('position')->default(1);
            $table->boolean('display')->default(1);
            $table->timestamps();

            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //
            $table->foreign('bank_cart_id')
                ->references('id')
                ->on('bank_carts')
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
        Schema::dropIfExists('checkouts');
    }
}
