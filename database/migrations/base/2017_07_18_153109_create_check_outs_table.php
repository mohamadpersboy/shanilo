<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_outs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('price');
            $table->string('price_check_out')->default(0);
            $table->string('tracking_code')->nullable();
            $table->unsignedInteger('pay_type')->default(1)->comment = "card_to_card = 1 / paya = 2";
            $table->unsignedInteger('pay_status')->default(1)->comment = "in progress = 1 / Tracked and confirmed = 2 / Not approved = 3";
            $table->unsignedInteger('user_bank_id');
            $table->unsignedInteger('user_id');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('user_bank_id')->references('id')->on('user_banks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_outs');
    }
}
