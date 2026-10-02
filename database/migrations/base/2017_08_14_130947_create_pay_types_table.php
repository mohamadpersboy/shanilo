<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',512);
            $table->text('description');
            $table->string('icon')->nullable();
            $table->enum('type',['online','home','credit'])->default('online');
            $table->string('price_max',512);
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
        Schema::dropIfExists('pay_types');
    }
}
