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
                        SELECT p.*, fv.*
                        FROM products as p
                        LEFT JOIN field_values as fv ON p.stock_type_id = fv.id
                        LEFT JOIN product_category as pc ON p.id = pc.product_id
                        LEFT JOIN categories as c ON pc.category_id = c.id WHERE pc.is_main = 1

                        WHERE pc.is_main = 1 AND p.status = 1 AND p.group_id = 4 AND p.is_in_home = 1
                        "
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
