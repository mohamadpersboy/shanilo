<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',512)->nullable();
            $table->string('title',512)->nullable();
            $table->text('message');
            $table->unsignedInteger('user_id')->nullable()->index();
            $table->unsignedInteger('parent_id')->nullable()->index();
            $table->unsignedInteger('status')->default(1)->comment = "waiting = 1 / answered = 2";
            $table->unsignedInteger('seenStatus')->default(2)->comment = "Not seen = 1 / seen = 2";
            $table->unsignedInteger('priority')->nullable()->comment = "low = 1 / medium = 2 / high = 3";
            $table->softDeletes();
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
        Schema::dropIfExists('tickets');
    }
}
