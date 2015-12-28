<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade');

            $table->tinyInteger('status')->unsigned();

            $table->decimal('amount', 10, 2);
            $table->char('currency', 3);
            $table->string('method', 32);
            $table->text('metadata');
            $table->dateTime('paid')->nullable();

            $table->string('billing_name', 64);
            $table->string('billing_line_1', 64);
            $table->string('billing_line_2', 64)->nullable();
            $table->string('billing_city', 32);
            $table->string('billing_postcode', 10);
            $table->string('billing_state', 32)->nullable();
            $table->string('billing_phone', 32);
            $table->integer('billing_country_id');
            $table->foreign('billing_country_id')
                ->references('id')->on('countries')
                ->onDelete('no action');

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
        Schema::drop('order_payments');
    }
}
