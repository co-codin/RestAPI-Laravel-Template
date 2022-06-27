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
                        SELECT
                            p.id, p.name, p.article, p.image, p.slug, p.group_id,
                            c.name AS category_name,
                            b.name AS brand_name,
                            fv.value AS stock_type_value,
                            pv.id AS variation_id, pv.price, pv.previous_price, pv.is_price_visible, pv.currency_id,
                            cur.rate AS currency_rate,
                            img.image AS img

                        FROM products as p
                        LEFT JOIN field_values AS fv ON p.stock_type_id = fv.id
                        LEFT JOIN product_category AS pc ON p.id = pc.product_id
                        LEFT JOIN categories AS c ON pc.category_id = c.id AND pc.is_main = 1
                        LEFT JOIN brands AS b ON p.brand_id = b.id
                        LEFT JOIN product_variations AS pv ON p.id = pv.product_id
                        LEFT JOIN currencies AS cur ON pv.currency_id = cur.id
                        LEFT JOIN images as img ON p.id = img.imageable_id AND img.imageable_type = 'Modules\\Product\\Models\\Product'
//                        LEFT JOIN product_reviews
                        
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
