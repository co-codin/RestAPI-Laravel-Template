<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_value', function (Blueprint $table) {
            $table->primary(['property_id']);
            // TODO module Product
//            $table->primary(['property_id', 'product_id']);
            $table->foreignId('property_id')->constrained();
            // TODO module Product
//            $table->foreignId('product_id')->constrained();
            $table->json('value')->nullable();
            $table->string('pretty_key')->nullable();
            $table->string('pretty_value')->nullable();
            $table->boolean('is_important')->default(false);
            $table->tinyInteger('important_position')->default(null);
            $table->string('important_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_value');
    }
}
