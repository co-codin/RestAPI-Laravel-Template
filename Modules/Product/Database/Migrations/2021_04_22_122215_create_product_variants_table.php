<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->string('name');
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('previous_price')->nullable();
            // TODO currecies table
//            $table->foreignId('currency_id')->constrained();
            $table->boolean('is_price_visible')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->unsignedTinyInteger('availability')->default(1);
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
        Schema::dropIfExists('product_variants');
    }
}
