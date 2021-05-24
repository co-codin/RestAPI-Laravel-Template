<?php


namespace App\Services;


use App\Enums\Status;
use Modules\Product\Models\Product;

class ElasticsearchService
{
    public function indexForProducts()
    {
        return Product::query()->fromQuery("
                SELECT
                    p.id,
                    p.name,
                    p.slug,
                    p.status,
                    p.brand_id
                FROM
                    products AS p
                WHERE
                    p.status = " . Status::Active . "
                    AND EXISTS (
                        SELECT
                            1
                        FROM
                            product_variations AS pv
                        WHERE
                            pv.product_id = p.id
                            AND pv.status = " . Status::Active . "
                        )
                    AND EXISTS (
                        SELECT
                            1
                        FROM
                            product_categories AS pc
                            JOIN categories AS cat ON cat.id = pc.category_id
                        WHERE
                            pc.product_id = p.id
                            AND cat.status = " . Status::Active . "
                        )
                    AND EXISTS (
                        SELECT
                            1
                        FROM
                            brands AS b
                        WHERE
                            p.brand_id = b.id
                            AND b.status = " . Status::Active . "
                        )
        ");
    }
}
