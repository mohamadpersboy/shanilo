<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('section')->nullable();
            $table->string('title'); // like: Developer's Email
            $table->string('name');  // like: email
            $table->text('value')->nullable(); // like: me@hamidteimouri.com
            $table->enum('type',['string','file','bool','text'])->default('string');
            $table->unsignedInteger('position')->default(1);
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
        Schema::connection('mysql')->dropIfExists('settings');
    }
}
