<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_description', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')
                ->references('id')->on('languages')
                ->onDelete('no action');

            $table->string('slug', 255)->unique();

            $table->primary(['product_id', 'language_id']);

            $table->string('title', 255);
            $table->text('description');
            $table->string('meta_description', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products_description');
    }
}
