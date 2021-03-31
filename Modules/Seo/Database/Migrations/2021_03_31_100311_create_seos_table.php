<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('seoable');
            $table->unsignedTinyInteger('is_enabled')->default(2);
            $table->string('title', 1000)->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('h1', 1000)->nullable();
            $table->json('meta_tags')->nullable();
            $table->json('texts')->nullable();
            $table->unsignedTinyInteger('type')->default(1);
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
        Schema::dropIfExists('seos');
    }
}
