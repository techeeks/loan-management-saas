<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanSubscriptionUsageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_subscription_usage', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_id')->unsigned();
            $table->integer('feature_id')->unsigned();
            $table->smallInteger('used')->unsigned();
            $table->dateTime('valid_until')->nullable();
            $table->string('timezone')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['subscription_id', 'feature_id']);
            $table->foreign('subscription_id')->references('id')->on('plan_subscriptions')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('feature_id')->references('id')->on('plan_features')
                  ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_subscription_usage');
    }
}
