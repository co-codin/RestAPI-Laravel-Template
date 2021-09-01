<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->bigInteger('city_id')->unsigned();
            $table->unsignedTinyInteger('type')->default(1);
            $table->boolean('is_enabled')->default(true);

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sold_products');
    }
}
