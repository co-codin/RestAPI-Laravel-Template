<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_question_id')->constrained();
            $table->string('text');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('person')->nullable();
            $table->unsignedTinyInteger('like')->default(0);
            $table->unsignedTinyInteger('dislike')->default(0);
            $table->timestamp('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_answers');
    }
}
