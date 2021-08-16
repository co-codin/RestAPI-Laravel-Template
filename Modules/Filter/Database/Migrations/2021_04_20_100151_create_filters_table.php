<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('property_id')->nullable()->constrained();
            $table->unsignedTinyInteger('type')->default(1);
            $table->foreignId('category_id')->constrained();
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_default')->default(false);
            $table->text('description')->nullable();
            $table->unsignedInteger('position')->nullable();
            $table->json('options')->nullable();
            $table->timestamps();

//            $table->unique(['category_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters');
    }
}
