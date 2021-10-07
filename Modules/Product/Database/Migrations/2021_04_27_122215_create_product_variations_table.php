<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->string('name');
            $table->unsignedBigInteger('price')->nullable();
            $table->unsignedBigInteger('previous_price')->nullable();
            $table->foreignId('currency_id')->nullable()->constrained();
            $table->boolean('is_price_visible')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->unsignedTinyInteger('availability')->default(1);
            $table->unsignedInteger('condition')->nullable();
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
        Schema::dropIfExists('product_variations');
    }
}
