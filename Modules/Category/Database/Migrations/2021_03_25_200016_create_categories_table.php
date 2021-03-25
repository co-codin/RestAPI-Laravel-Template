<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('product_name')->nullable();
            $table->text('full_description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('hide_in_parents')->default(1);
            $table->boolean('is_in_home')->default(false);
            $table->string('image')->nullable();
            $table->json('links')->nullable();
            $table->nestedSet();
            $table->json('short_properties')->nullable();
            $table->tinyInteger('new_structure')->default(0);
            $table->unsignedTinyInteger('is_finished')->default(0);
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
        Schema::dropIfExists('categories');
    }
}
