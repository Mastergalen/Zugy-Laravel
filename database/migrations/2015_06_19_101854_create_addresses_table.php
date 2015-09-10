<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->boolean('isShippingPrimary');
            $table->boolean('isBillingPrimary');

            $table->string('name', 64);
            $table->string('line_1', 64);
            $table->string('line_2', 64);
            $table->string('city', 32);
            $table->string('postcode', 10);
            $table->string('state', 32);
            $table->string('phone', 32);

            $table->integer('country_id');
            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('no action');

            $table->text('delivery_instructions')->nullable();

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
        Schema::drop('addresses');
    }
}
