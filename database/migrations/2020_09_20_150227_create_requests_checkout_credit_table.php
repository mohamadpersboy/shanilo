<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsCheckoutCreditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests_checkout_credit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('bank_cart_id');
            $table->float('price', 15, 2);
            $table->string('tracking_code')->nullable();
            $table->timestamp('request_at')->nullable();
            $table->timestamp('done_at')->nullable();
            $table->enum('status', ['pending', 'done', 'reject'])->default('pending');

        });

        DB::statement('alter table requests_checkout_credit  auto_increment = 13990001');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests_checkout_credit');
    }
}
