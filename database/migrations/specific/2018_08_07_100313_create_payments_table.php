<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pay_type_id');
            $table->morphs('payable');
            $table->string('transaction_id')->nullable();
            $table->string('tracking_code')->nullable();
            $table->string('ref_id')->nullable();
            $table->integer('price');
            $table->enum('status', ['pending', 'successful', 'unsuccessful'])->default('pending');
            $table->unsignedInteger('position')->default(1);
            $table->boolean('display')->default(1);
            $table->timestamps();

            $table->foreign('pay_type_id')
                ->references('id')
                ->on('pay_types')
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
        Schema::dropIfExists('payments');
    }
}
