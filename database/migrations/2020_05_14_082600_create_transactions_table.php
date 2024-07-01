<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('car_id')->constrained('cars');
            $table->string('invoice_no');
            $table->dateTime('rent_date');
            $table->dateTime('back_date')->nullable();
            $table->dateTime('return_date')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('penalty')->nullable();
            $table->string('status');
            $table->softDeletes();
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
        Schema::dropIfExists('transactions');
    }
}
