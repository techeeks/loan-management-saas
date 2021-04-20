<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->date('loan_date');
            $table->date('return_date');
            $table->enum('status',['Pending','Paid','Overdue']);
            $table->text('description');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
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
        Schema::dropIfExists('loan_requests');
    }
}
