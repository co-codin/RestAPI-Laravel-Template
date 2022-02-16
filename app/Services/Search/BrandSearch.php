<?php

namespace App\Services\Search;

use App\Services\Interfaces\SearchInterface;
use Illuminate\Support\Facades\DB;

class BrandSearch implements SearchInterface
{
    public function search($query, array $mapping)
    {
        $builder = DB::table('brands')
            ->select([
                'brands.id',
                'brands.name',
                DB::raw("'brands' AS type"),
                DB::raw("'Производители' AS type_ru"),
                DB::raw("
                    CONCAT_WS('/', 'https://medeq.ru', 'brands', slug) AS public_url
                "),
                DB::raw("
                    CONCAT_WS('/', 'https://control.medeq.ru/brands', brands.id, 'update') AS admin_url
                ")
            ])
            ->leftJoin('seo', function ($leftJoin) {
                $leftJoin->on('seo.seoable_id', '=', 'brands.id')
                    ->where('seo.seoable_type', 'LIKE', '%brand%');
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
