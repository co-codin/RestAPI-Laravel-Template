<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MarkNullableClientIdAndAddnamesToProductQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_questions', function (Blueprint $table) {
            $table->bigInteger('client_id')->unsigned()->nullable()->change();
            $table->string('last_name')->nullable()->after('client_id');
            $table->string('first_name')->nullable()->after('client_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_questions', function (Blueprint $table) {
            $table->bigInteger('client_id')->unsigned()->change();
            $table->dropColumn('first_name', 'last_name');
        });
    }
}
