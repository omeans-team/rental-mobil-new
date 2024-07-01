<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('manufacture_id');
            $table->string('name');
            $table->string('license_number')->unique();
            $table->string('color');
            $table->string('year');
            $table->string('status');
            $table->unsignedInteger('price');
            $table->unsignedInteger('penalty');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('manufacture_id')->references('id')->on('manufactures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
