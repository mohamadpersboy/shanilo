<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('price',255);
            $table->string('discount',255)->nullable();
            $table->string('price_discount',255)->nullable();
            $table->unsignedInteger('ad_plan_id');
            $table->unsignedInteger('ad_time_id');
            $table->unsignedInteger('position')->default(1);
            $table->boolean('display')->default(1);
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
        Schema::dropIfExists('ad_details');
    }
}
