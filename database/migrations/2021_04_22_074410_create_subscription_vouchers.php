<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('plan_id');
            $table->string('voucher_code')->unique();
            $table->string('voucher_name');
            $table->timestamps();
            $table->enum('status',['New','Used'])->default("New");
            $table->foreign('plan_id')->references('id')->on('plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_vouchers');
    }
}
