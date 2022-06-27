<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductsHotView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW products_hot_view AS
                        SELECT *
                        FROM companies AS c"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW products_hot_view");
    }
}
