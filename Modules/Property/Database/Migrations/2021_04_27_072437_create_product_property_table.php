<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_property', function (Blueprint $table) {
            $table->primary(['property_id', 'product_id']);
            $table->foreignId('property_id')->constrained();
            $table->foreignId('product_id')->constrained();

            $table->json('field_value_ids')->nullable();
//            $table->json('options')->nullable();
//            $field_value_ids = DB::connection()->getQueryGrammar()->wrap('options->field_value_ids');
//            $table->unsignedInteger('field_value_ids')->storedAs($field_value_ids);
//            $table->foreign('field_value_ids')->references('id')->on('field_values');

            $table->json('value')->nullable();
            $table->string('pretty_key')->nullable();
            $table->string('pretty_value')->nullable();
            $table->boolean('is_important')->default(false);
            $table->unsignedTinyInteger('important_position')->nullable();
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
        Schema::dropIfExists('product_property');
    }
}
