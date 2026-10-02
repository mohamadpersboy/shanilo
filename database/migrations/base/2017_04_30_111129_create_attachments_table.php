<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('attachmentable');
            //This field is specific in this project
             $table->integer('quality_id')->nullable()->unsigned();
            //
            $table->string('title', 512)->nullable();
            $table->string('subtitle')->nullable();
            $table->string('slug')->nullable();
            $table->string('file_name',512)->nullable();
            $table->string('mime')->nullable(); // like: png/jpeg/jpg
            $table->string('size')->nullable(); // kilobyte
            $table->string('size_format')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('dl')->default(1);
            $table->unsignedInteger('count')->default(1);
            $table->string('group_name')->nullable();
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
        Schema::connection('mysql')->dropIfExists('attachments');
    }
}
