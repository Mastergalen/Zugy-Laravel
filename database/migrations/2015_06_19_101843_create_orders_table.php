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
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('no action');

            $table->tinyInteger('order_status')->unsigned();
            $table->tinyInteger('payment_status')->unsigned();
            $table->dateTime('order_placed');
            $table->dateTime('order_completed');
            $table->text('comments');

            $table->string('delivery_name', 64);
            $table->string('delivery_street', 64);
            $table->string('delivery_city', 32);
            $table->string('delivery_postcode', 10);
            $table->string('delivery_state', 32);
            $table->string('delivery_country', 32);

            $table->char('currency', 3);
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
