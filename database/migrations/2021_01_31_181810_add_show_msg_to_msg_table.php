<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowMsgToMsgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('msg', function (Blueprint $table) {
            $table->string('is_show')->default('1')->after('is_ticket');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('msg', function (Blueprint $table) {
            $table->dropColumn('is_show');
        });
    }
}
