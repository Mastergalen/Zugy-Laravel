<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes_description', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('attribute_id')->unsigned();
            $table->foreign('attribute_id')
                ->references('id')->on('attributes')
                ->onDelete('no action');

            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')
                ->references('id')->on('languages')
                ->onDelete('no action');

            $table->primary(['attribute_id', 'language_id']);

            $table->string('name', 32);
            $table->string('unit', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attributes_description');
    }
}
