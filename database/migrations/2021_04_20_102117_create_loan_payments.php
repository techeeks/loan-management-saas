<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('loan_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->float('amount');
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->text('private_notes')->nullable();
            $table->timestamps();
            $table->foreign('loan_id')->references('id')->on('loan_requests')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_payments');
    }
}
