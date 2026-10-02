<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wallet_id');
            $table->unsignedInteger('order_id');
            $table->enum('type', ['sub', 'add']);
            $table->string('source');
            $table->string('destination');
            $table->unsignedInteger('price');
            $table->timestamps();

            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
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
        Schema::dropIfExists('wallet_transactions');
    }
}
