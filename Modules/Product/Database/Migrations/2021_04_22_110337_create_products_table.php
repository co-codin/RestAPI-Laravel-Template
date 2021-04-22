<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(1);
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('brand_id')->constrained();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('image')->nullable();
            $table->boolean('is_in_home')->default(false);
            $table->unsignedTinyInteger('warranty')->nullable();
            $table->json('options')->nullable();
            $table->json('media')->nullable();
            $table->json('documents')->nullable();
            $table->text('short_description')->nullable();
            $table->text('full_description')->nullable();
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
        Schema::dropIfExists('products');
    }
}
