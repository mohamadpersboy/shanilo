<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('family');
            $table->string('email');
            $table->string('mobile');
            $table->string('phone');
            $table->text('address');
            $table->string('latlong',255)->nullable();
            $table->string('zip_code');
            $table->enum('place_type',['home','office']);
            $table->unsignedInteger('selected')->default(0);
            $table->unsignedInteger('deleted')->default(0);
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('state_id');
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('addresses');
    }
}
