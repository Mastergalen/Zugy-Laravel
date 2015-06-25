<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('stock_quantity')->unsigned();
            $table->decimal('price', 10, 2);
            $table->decimal('weight', 7, 2);
            $table->dateTime('date_added');

            $table->integer('tax_class_id')->unsigned();
            $table->foreign('tax_class_id')
                ->references('id')->on('tax_classes')
                ->onDelete('restrict');
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
        Schema::drop('products');
    }
}
