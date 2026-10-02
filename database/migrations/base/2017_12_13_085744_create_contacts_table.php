<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('phone');
            $table->string('mobile')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('support_phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email');
            $table->text('address');
            $table->boolean('main')->default(0);
            $table->double('latitude');
            $table->double('longitude');
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
        Schema::dropIfExists('contacts');
    }
}
