<?php

namespace App\Services\Search;

use App\Services\Interfaces\SearchInterface;
use Illuminate\Support\Facades\DB;

class ProductSearch implements SearchInterface
{
    public function search($query, array $mapping)
    {
        $builder = DB::table('products')
            ->selectRaw('
                products.id
	            "products" AS type
	            "Товары" AS type_ru
                CONCAT_WS("/", "https://medeq.ru", "product", slug, products.id) AS public_url
                CONCAT_WS("/", "https://control.medeq.ru/products", products.id, "update") AS admin_url
            ')
            ->leftJoin('seo', function ($leftJoin) {
                $leftJoin->on('seo.seoable_id', '=', 'products.id')
                    ->where('seo.seable_type', 'LIKE', '%product%');
            })
            ;

        foreach ($mapping['columns'] as $column) {
            $builder->orWhereRaw("regexp_replace({$column}, '[^A-ZА-Яа-яa-z0-9]', '') LIKE %{$query}% OR");
        }

        return $builder;
    }
}
