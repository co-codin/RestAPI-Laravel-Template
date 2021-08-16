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
            $table->nestedSet();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('product_name')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_in_home')->default(false);
            $table->boolean('is_hidden_in_parents')->default(false);
            $table->text('full_description')->nullable();
            $table->unsignedBigInteger('assigned_by_id')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
