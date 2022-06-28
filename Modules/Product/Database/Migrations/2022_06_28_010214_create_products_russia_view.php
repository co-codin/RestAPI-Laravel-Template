<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductsRussiaView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW products_russia_view");
    }
}
