<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id');
            $table->string('name')->nullable();
            $table->string('address');
            $table->json('coordinate');
            $table->string('embed_map_url', 500)->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('info')->nullable();
            $table->json('timetable')->nullable();
            $table->tinyInteger('type');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('order_points');
    }
}
