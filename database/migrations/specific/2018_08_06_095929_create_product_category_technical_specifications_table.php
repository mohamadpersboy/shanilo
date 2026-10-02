<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryTechnicalSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category_technical_specifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_category_id');
            $table->unsignedInteger('technical_specification_id');
            $table->unsignedInteger('position')->default(1);
            $table->boolean('display')->default(1);
            $table->timestamps();

            $table->foreign('product_category_id','pc_ts_id_foreign')
                ->references('id')
                ->on('product_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('technical_specification_id','pc_ts_id_2_foreign')
                ->references('id')
                ->on('technical_specifications')
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
        Schema::dropIfExists('product_category_technical_specifications');
    }
}
