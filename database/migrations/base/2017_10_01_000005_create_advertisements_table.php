<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('family')->nullable();
            $table->string('mobile')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->string('link');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('ad_plan_id');
            $table->unsignedInteger('ad_time_id');
            $table->unsignedInteger('position')->default(1);
            $table->boolean('display')->default(0);
            $table->timestamp('expire_at')->nullable();
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
        Schema::dropIfExists('advertisements');
    }
}
