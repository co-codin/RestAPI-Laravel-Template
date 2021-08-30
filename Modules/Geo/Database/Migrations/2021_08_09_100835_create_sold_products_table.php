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
            $table->foreignId('product_id')->nullable()->constrained();
            $table->foreignId('city_id')->constrained();
            $table->foreignId('category_id')->nullable()->constrained()->nullable();
            $table->unsignedTinyInteger('type')->default(1);
            $table->unsignedTinyInteger('status')->default(1);
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
