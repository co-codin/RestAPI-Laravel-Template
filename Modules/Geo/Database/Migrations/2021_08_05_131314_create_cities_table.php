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
            $table->string('region_name');
            $table->string('region_name_with_type');
            $table->string('federal_district');
            $table->string('iso');

            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedTinyInteger('status');
            $table->boolean('is_default')->default(false);
            $table->json('coordinate');
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
