<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msg', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->integer('sender_id')->default(0);
            $table->integer('receiver_id')->default(0);
            $table->boolean('is_ticket')->default(0);
            $table->timestamps();
        });

        Schema::create('msg_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('msg_id');
            $table->text('description')->nullable();
            $table->text('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('msg_details');
        Schema::dropIfExists('msg');
    }
}
