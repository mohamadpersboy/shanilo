<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstPageSpecialSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('first_page_special_sells', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('special_sell_id');
            $table->unsignedInteger('plan_id');
            $table->timestamp('expires_at')->nullable()->default(null);
            $table->unsignedInteger('position')->default(1);
            $table->boolean('display')->default(1);
            $table->timestamps();

            $table->foreign('special_sell_id')
                ->references('id')
                ->on('special_sells')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('first_page_special_sells');
    }
}
