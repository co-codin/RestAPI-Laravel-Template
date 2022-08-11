<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReleasedDateIntoCaseModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_models', function (Blueprint $table) {
            $table->tinyInteger('released_year')->nullable()->after('status');
            $table->tinyInteger('released_quarter')->nullable()->after('released_year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_models', function (Blueprint $table) {
            $table->dropColumn('released_year');
            $table->dropColumn('released_quarter');
        });
    }
}
