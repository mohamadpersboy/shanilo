<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
            $table->string('price_after_discount')->nullable();
            $table->unsignedInteger('send_type_id')->nullable();
            $table->string('send_type_price',256)->nullable();
            $table->string('send_type_time',256)->nullable();
            $table->unsignedInteger('pay_type_id')->nullable();
            $table->unsignedInteger('address_id')->nullable();
            $table->unsignedInteger('send_status')->default(1)->comment = "not send = 1 / sending = 2 / sent = 3";
            $table->string('log',1024)->nullable();
            $table->string('description',1024)->nullable();
            $table->string('price_returned',512)->nullable();
            $table->unsignedInteger('visited')->default(1)->comment = "Not tracked = 1 / tracked = 2 / Cancel tracking = 3";
            $table->unsignedInteger('factor_subject')->default(1)->comment = "products = 1 / request order = 2";
            $table->unsignedInteger('factor_status')->default(1)->comment = "Awaiting Payment = 1 / final purchase = 2";
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
        Schema::dropIfExists('factors');
    }
}
