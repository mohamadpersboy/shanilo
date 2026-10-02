<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('family');
            $table->string('mobile');
            $table->string('tel');
            $table->string('email');
            $table->string('link');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('ad_plan_id');
            $table->unsignedInteger('ad_time_id');
            $table->unsignedInteger('status')->default(1);
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
        Schema::dropIfExists('ad_requests');
    }
}
