<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('family')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('uid')->unique();
            $table->string('password');
            $table->string('mobile')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('credit')->default(0);
            $table->string('national_code')->nullable();
            $table->integer('confirm')->default(0);
            $table->string('hashed')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('show_info')->default(0);
            $table->string('session_id',250)->nullable();
            $table->unsignedInteger('role_id')->default('3');
            $table->timestamp('birth_date')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
