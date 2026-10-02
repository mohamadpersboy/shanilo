<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitySendTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_send_type', function (Blueprint $table) {
            $table->primary(['city_id','send_type_id']);
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('send_type_id');
            $table->string('price',512);
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
        Schema::dropIfExists('city_send_type');
    }
}
