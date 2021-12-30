<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariationLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variation_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variation_id')->constrained();
            $table->unsignedTinyInteger('supplier');
            $table->string('resource');
            $table->boolean('is_default')->default(0);
            $table->json('check')->nullable();
            $table->foreignId('currency_id')->constrained();
            $table->unsignedBigInteger('price');
            $table->unsignedTinyInteger('availability');
            $table->json('xpath')->nullable();

            $table->timestamp('info_updated_at');
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
        Schema::dropIfExists('variation_links');
    }
}
