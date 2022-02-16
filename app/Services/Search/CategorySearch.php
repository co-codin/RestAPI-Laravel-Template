<?php

namespace App\Services\Search;

use App\Services\Interfaces\SearchInterface;
use Illuminate\Support\Facades\DB;

class CategorySearch implements SearchInterface
{
    public function search($query, array $mapping)
    {
        $builder = DB::table('categories')
            ->select([
                'categories.id',
                'seo.*',
                DB::raw("'categories' AS type"),
                DB::raw("'Категории' AS type_ru"),
                DB::raw("
                    CONCAT_WS('/', 'https://medeq.ru', 'store', slug) AS public_url
                "),
                DB::raw("
                    CONCAT_WS('/', 'https://control.medeq.ru/categories', categories.id, 'update') AS admin_url
                ")
            ])
            ->leftJoin('seo', function ($leftJoin) {
                $leftJoin->on('seo.seoable_id', '=', 'categories.id')
                    ->where('seo.seoable_type', 'LIKE', '%category%');
            })
        ;

        foreach ($mapping['columns'] as $column) {
            $builder->orWhere(
                DB::raw("regexp_replace({$column}, '[^A-ZА-Яа-яa-z0-9]', '')"),
                'LIKE',
                "%{$query}%"
            );
        }

        return $builder->get();
    }
}
