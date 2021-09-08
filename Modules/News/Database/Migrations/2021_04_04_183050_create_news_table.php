<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->string('short_description', 900)->nullable();
            $table->text('full_description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('image')->nullable();
            $table->boolean('is_in_home')->default(true);
            $table->unsignedInteger('view_num')->nullable();
            $table->timestamp('published_at');
            $table->unsignedBigInteger('assigned_by_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('news');
    }
}
