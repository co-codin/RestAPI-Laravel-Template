<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsInVariationsColumnIntoProductPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_property', function (Blueprint $table) {
            $table->boolean('is_in_variations')->nullable()->default(false)->after('important_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_property', function (Blueprint $table) {
            $table->dropColumn('is_in_variations');
        });
    }
}
