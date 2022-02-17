<?php

namespace App\Services\Search;

use App\Services\Abstracts\SearchAbstract;
use Illuminate\Support\Facades\DB;

class PageSearch extends SearchAbstract
{
    public function extends($query, array $mapping)
    {
        $builder = DB::table('pages')
            ->select([
                'pages.id',
                'pages.name',
                DB::raw("'pages' AS type"),
                DB::raw("'Страницы' AS type_ru"),
                DB::raw("
                    CONCAT_WS('/', {$this->getSiteUrl()}, 'page', slug) AS public_url
                "),
                DB::raw("
                    CONCAT_WS('/', {$this->getAdminUrl()}, 'pages', pages.id, 'update') AS admin_url
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
