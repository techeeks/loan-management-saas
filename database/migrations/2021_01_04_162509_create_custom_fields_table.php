<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uid')->unique();
            $table->unsignedBigInteger('company_id');
            $table->string('model_type');
            $table->string('name');
            $table->string('label');
            $table->string('type');
            $table->string('placeholder')->nullable();
            $table->boolean('is_required')->default(false);
            $table->text('string_answer')->nullable();
            $table->unsignedBigInteger('number_answer')->nullable();
            $table->boolean('boolean_answer')->nullable();
            $table->dateTime('date_time_answer')->nullable();
            $table->date('date_answer')->nullable();
            $table->time('time_answer')->nullable();
            $table->json('options')->nullable();
            $table->unsignedBigInteger('order')->default(1);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_fields');
    }
}
