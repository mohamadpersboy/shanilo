<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstPageSpecialSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('first_page_special_suggestions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('special_suggestion_id');
            $table->unsignedInteger('plan_id');
            $table->timestamp('expires_at')->nullable()->default(null);
            $table->unsignedInteger('position')->default(1);
            $table->boolean('display')->default(1);
            $table->timestamps();

               $table->foreign('special_suggestion_id')
                                   ->references('id')
                                   ->on('special_suggestions')
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
        Schema::dropIfExists('first_page_special_suggestions');
    }
}
