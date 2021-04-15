<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedTinyInteger('type')->default(1);
            $table->unsignedTinyInteger('is_system')->default(2);
            $table->string('system_field')->nullable();
            $table->unsignedTinyInteger('in_all_categories')->default(2);
            $table->text('options')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_hidden_from_product')->default(false);
            $table->boolean('is_hidden_from_comparison')->default(false);
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
        Schema::dropIfExists('properties');
    }
}
