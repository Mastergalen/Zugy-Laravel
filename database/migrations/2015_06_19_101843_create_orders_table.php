<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('no action');

            $table->tinyInteger('order_status')->unsigned();
            $table->dateTime('order_placed');
            $table->dateTime('order_completed')->nullable();
            $table->text('comments');

            $table->string('email');
            $table->string('delivery_name', 64);
            $table->string('delivery_line_1', 64);
            $table->string('delivery_line_2', 64)->nullable();
            $table->string('delivery_city', 32);
            $table->string('delivery_postcode', 10);
            $table->string('delivery_state', 32);
            $table->string('delivery_phone', 32);
            $table->integer('delivery_country_id');
            $table->foreign('delivery_country_id')
                ->references('id')->on('countries')
                ->onDelete('no action');
            $table->text('delivery_instructions')->nullable();

            $table->decimal('shipping_fee', 10, 2)->unsigned();

            $table->char('currency', 3);

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
        Schema::drop('orders');
    }
}
