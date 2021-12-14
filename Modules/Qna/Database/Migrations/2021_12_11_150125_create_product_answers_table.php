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
            $table->bigInteger('question_id')->unsigned();
            $table->string('text');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('person')->nullable();
            $table->unsignedTinyInteger('like');
            $table->unsignedTinyInteger('dislike');
            $table->timestamp('created_at');

            $table->foreign('question_id')->references('id')->on('product_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
