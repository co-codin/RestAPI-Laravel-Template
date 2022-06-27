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
                            img.image AS img,
                            pr.ratings


                        FROM products as p



                        LEFT JOIN field_values AS fv ON p.stock_type_id = fv.id
                        LEFT JOIN product_category AS pc ON p.id = pc.product_id
                        LEFT JOIN categories AS c ON pc.category_id = c.id AND pc.is_main = 1
                        LEFT JOIN brands AS b ON p.brand_id = b.id
                        LEFT JOIN product_variations AS pv ON p.id = pv.product_id AND pv.previous_price IS NOT NULL AND pv.price IS NOT NULL AND pv.is_price_visible = 1
                        LEFT JOIN currencies AS cur ON pv.currency_id = cur.id
                        LEFT JOIN images AS img ON p.id = img.imageable_id AND img.imageable_type = 'Modules\\Product\\Models\\Product'
                        LEFT JOIN product_reviews AS pr ON p.id = pr.product_id AND pr.status = 2
                        LEFT JOIN product_questions AS pq ON p.id = pq.product_id AND pq.status = 2
                        LEFT JOIN product_answers AS pa ON pa.product_question_id = pq.id


                        WHERE
                            NOT EXISTS (SELECT NULL FROM product_property AS pp WHERE pp.product_id = p.id AND pp.property_id = 259 AND field_value_ids = 1)
                            AND pc.is_main = 1 AND p.status = 1 AND p.group_id = 4 AND p.is_in_home = 1
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
