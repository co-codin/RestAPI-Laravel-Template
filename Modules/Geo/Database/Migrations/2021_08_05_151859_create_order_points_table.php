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
            $table->unsignedBigInteger('city_id')->index();
            $table->string('address');
            $table->json('coordinate');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('info')->nullable();
            $table->json('timetable')->nullable();
            $table->tinyInteger('type');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('region_cities')->onDelete('CASCADE');
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
