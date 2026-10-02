<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('notificable');
            $table->unsignedInteger('master_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('status')->default(1);
            $table->unsignedInteger('type')->nullable()->comment = "like = 1 / rate = 2 / comment = 3";
            $table->unsignedInteger('more_id')->nullable();
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
        Schema::dropIfExists('my_notifications');
    }
}
