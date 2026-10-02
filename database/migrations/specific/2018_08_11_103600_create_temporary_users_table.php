<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporaryUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('family')->nullable();
            $table->string('email')->nullable();
            $table->string('uid');
            $table->string('password');
            $table->string('mobile')->nullable();
            $table->string('hashed')->nullable();
            $table->boolean('show_info')->default(0);
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
        Schema::dropIfExists('temporary_users');
    }
}
