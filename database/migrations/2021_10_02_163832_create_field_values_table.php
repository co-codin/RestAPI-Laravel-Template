<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldValuesTable extends Migration
{
    public function up()
    {
        Schema::create('field_values', function (Blueprint $table) {
            $table->id();
            $table->string('value', 1000);
            $table->string('slug')->nullable(); // TODO нужно будет поменять на unique
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('field_values');
    }
}
