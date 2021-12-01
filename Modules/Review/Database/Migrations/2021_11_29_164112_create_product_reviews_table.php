<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unsigned();
            $table->unsignedTinyInteger('experience');
            $table->string('advantages');
            $table->string('disadvantages');
            $table->text('comment');
            $table->unsignedTinyInteger('status')->default(1);
            $table->boolean('is_confirmed')->default(false);
            $table->json('ratings');
            $table->unsignedSmallInteger('like')->default(0);
            $table->unsignedSmallInteger('dislike')->default(0);
            $table->timestamps();

            $table->index('client_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_reviews');
    }
}
