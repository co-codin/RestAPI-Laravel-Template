<?php

namespace App\Services\Search;

use App\Services\Abstracts\SearchAbstract;
use Illuminate\Support\Facades\DB;

class NewsSearch extends SearchAbstract
{
    public function search($query, array $mapping)
    {
        $builder = DB::table('news')
            ->select([
                'news.id',
                'news.name',
                DB::raw("'news' AS type"),
                DB::raw("'Новости' AS type_ru"),
                DB::raw("
                    CONCAT_WS('/', '{$this->getSiteUrl()}', 'news', slug) AS public_url
                "),
                DB::raw("
                    CONCAT_WS('/', '{$this->getAdminUrl()}', 'news', news.id, 'update') AS admin_url
                ")
            ])
            ->leftJoin('seo', function ($leftJoin) {
                $leftJoin->on('seo.seoable_id', '=', 'news.id')
                    ->where('seo.seoable_type', 'LIKE', '%news%');
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
