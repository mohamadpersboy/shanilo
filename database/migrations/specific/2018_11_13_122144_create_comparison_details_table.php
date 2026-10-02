<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComparisonDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comparison_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('comparison_id');
            $table->unsignedInteger('product_id');
            $table->timestamps();

            $table->foreign('comparison_id')
                ->references('id')
                ->on('comparisons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
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
        Schema::dropIfExists('comparison_details');
    }
}
