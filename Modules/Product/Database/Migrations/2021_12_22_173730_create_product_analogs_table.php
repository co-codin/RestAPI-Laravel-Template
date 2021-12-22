<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAnalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_analogs', function (Blueprint $table) {
            $table->primary(['product_id', 'analog_id']);
            $table->foreignId('product_id')->constrained();
            $table->bigInteger('analog_id')->unsigned();
//            $table->unsignedSmallInteger('position')->nullable();

            $table->foreign('analog_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_analogs');
    }
}
