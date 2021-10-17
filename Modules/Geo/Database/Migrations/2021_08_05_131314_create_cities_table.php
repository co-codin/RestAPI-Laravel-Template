<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('federal_district')->nullable();
            $table->foreignId('region_id')->nullable()->constrained();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedTinyInteger('status')->default(1);
            $table->boolean('is_default')->default(false);
            $table->json('coordinate')->nullable();
            $table->string('dial_code')->nullable();
            $table->string('postal_index')->nullable();
            $table->string('region_phone')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('cities');
    }
}
