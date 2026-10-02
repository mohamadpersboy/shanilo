<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BigintUserKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('role_user', function (Blueprint $table) {
            $table->bigInteger("user_id")->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql')->table('role_user', function (Blueprint $table) {
            $table->integer("user_id")->unsigned()->change();
        });
    }
}
