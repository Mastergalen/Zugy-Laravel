<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 255)->unique();
            $table->dateTime('starts')->nullable();
            $table->dateTime('expires')->nullable();
            $table->decimal('minimumTotal', 10, 2)->unsigned()->nullable();
            $table->integer('percentageDiscount')->unsigned()->nullable();
            $table->decimal('flatDiscount', 10, 2)->unsigned()->nullable();
            $table->integer('max_uses')->unsigned()->nullable();
            $table->integer('uses')->unsigned()->default(0);
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
        Schema::drop('coupons');
    }
}
