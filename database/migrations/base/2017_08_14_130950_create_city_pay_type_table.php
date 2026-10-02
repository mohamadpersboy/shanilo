<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityPayTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_pay_type', function (Blueprint $table) {
            $table->primary(['city_id','pay_type_id']);
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('pay_type_id');
            $table->string('price',512)->nullable();
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
        Schema::dropIfExists('city_pay_type');
    }
}
