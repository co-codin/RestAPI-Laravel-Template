<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCabinetCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabinet_category', function (Blueprint $table) {
            $table->foreignId('cabinet_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->string('name');
            $table->unsignedInteger('count');
            $table->string('price')->nullable();
            $table->unsignedInteger('position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cabinet_category');
    }
}
