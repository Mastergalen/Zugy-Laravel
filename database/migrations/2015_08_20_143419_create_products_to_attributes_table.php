<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsToAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_to_attributes', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

            $table->integer('attribute_id')->unsigned();
            $table->foreign('attribute_id')
                ->references('id')->on('attributes')
                ->onDelete('cascade');

            $table->string('value', 255);

            $table->primary(['product_id', 'attribute_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products_to_attributes');
    }
}
