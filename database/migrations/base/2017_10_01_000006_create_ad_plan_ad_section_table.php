<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdPlanAdSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_plan_ad_section', function (Blueprint $table) {
            $table->primary(['ad_plan_id','ad_section_id']);
            $table->unsignedInteger('ad_plan_id');
            $table->unsignedInteger('ad_section_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_plan_ad_section');
    }
}
