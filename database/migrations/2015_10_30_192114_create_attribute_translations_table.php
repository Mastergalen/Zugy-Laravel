<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('attribute_id')->unsigned();
            $table->foreign('attribute_id')
                ->references('id')->on('attributes')
                ->onDelete('no action');

            $table->string('locale')->index();

            $table->unique(['attribute_id', 'locale']);

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
        Schema::drop('attribute_translations');
    }
}
