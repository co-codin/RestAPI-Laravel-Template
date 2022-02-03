<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeperateFullDescriptionColumnInVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn('full_description');
            $table->text('duty')->after('occupation')->nullable();
            $table->text('requirement')->after('duty')->nullable();
            $table->text('condition')->after('requirement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacancies', function (Blueprint $table) {
            $table->text('full_description')->nullable();
            $table->dropColumn('duty');
            $table->dropColumn('requirement');
            $table->dropColumn('condition');
        });
    }
}
