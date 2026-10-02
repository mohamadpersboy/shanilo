<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('receiver_id')->nullable();
            $table->unsignedInteger('shop_id')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(0);
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('messages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //
            $table->foreign('receiver_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //
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
        Schema::dropIfExists('messages');
    }
}
