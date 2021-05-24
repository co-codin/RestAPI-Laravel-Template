<?php


namespace Modules\Product\Repositories;


use App\Enums\Status;
use App\Repositories\BaseRepository;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\Criteria\ProductRequestCriteria;

class ProductRepository extends BaseRepository
{
    public function model()
    {
        return Product::class;
    }

    public function boot()
    {
        $this->pushCriteria(ProductRequestCriteria::class);
    }

    public function indexForProducts()
    {
        $data = Product::query()->select([
            'id', 'name', 'slug', 'status', 'brand_id'
        ])
        ->where('status', '=', Status::ACTIVE);

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
                    p.status = " . Status::ACTIVE . "
                    AND EXISTS (
                        SELECT
                            1
                        FROM
                            product_variations AS pv
                        WHERE
                            pv.product_id = p.id
                            AND pv.status = " . Status::ACTIVE . "
                        )
                    AND EXISTS (
                        SELECT
                            1
                        FROM
                            product_category AS pc
                            JOIN categories AS cat ON cat.id = pc.category_id
                        WHERE
                            pc.product_id = p.id
                            AND cat.status = " . Status::ACTIVE . "
                        )
                    AND EXISTS (
                        SELECT
                            1
                        FROM
                            brands AS b
                        WHERE
                            p.brand_id = b.id
                            AND b.status = " . Status::ACTIVE . "
                        )
        ")
            ->get();
    }
}
