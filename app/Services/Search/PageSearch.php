<?php

namespace App\Services\Search;

use App\Services\Interfaces\SearchInterface;
use Illuminate\Support\Facades\DB;

class PageSearch implements SearchInterface
{
    public function search($query, array $mapping)
    {
        $builder = DB::table('pages')
            ->select([
                'pages.id',
                'pages.name',
                DB::raw("'pages' AS type"),
                DB::raw("'Страницы' AS type_ru"),
                DB::raw("
                    CONCAT_WS('/', 'https://medeq.ru', 'page', slug) AS public_url
                "),
                DB::raw("
                    CONCAT_WS('/', 'https://control.medeq.ru/pages', pages.id, 'update') AS admin_url
                ")
            ])
            ->leftJoin('seo', function ($leftJoin) {
                $leftJoin->on('seo.seoable_id', '=', 'pages.id')
                    ->where('seo.seoable_type', 'LIKE', '%page%');
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
