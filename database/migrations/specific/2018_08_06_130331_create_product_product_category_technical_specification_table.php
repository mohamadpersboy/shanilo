<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProductCategoryTechnicalSpecificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product_category_technical_specification', function (Blueprint $table) {
            $table->unsignedInteger('product_category_technical_specification_id');
            $table->unsignedInteger('product_id');
            $table->string('value');

            $table->foreign('product_category_technical_specification_id','pc_tc_id_3_foreign')
                ->references('id')
                ->on('product_category_technical_specifications')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //
            $table->foreign('product_id','pc_tc_id_4_foreign')
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
        Schema::dropIfExists('product_product_category_technical_specification');
    }
}
