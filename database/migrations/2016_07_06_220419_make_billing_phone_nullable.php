<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class MakeBillingPhoneNullable
 * Fixes a bug where if a customer had a billing address different from his delivery address, the billing address
 * would not have a phone.
 * When inserting a billing address into order_payments, phone was not allowed to be null.
 */
class MakeBillingPhoneNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_payments', function (Blueprint $table) {
            $table->string('billing_phone', 32)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_payments', function (Blueprint $table) {
            $table->string('billing_phone', 32)->change();
        });
    }
}
