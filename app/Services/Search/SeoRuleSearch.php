<?php

namespace App\Services\Search;

use App\Services\Interfaces\SearchInterface;
use Illuminate\Support\Facades\DB;

class SeoRuleSearch implements SearchInterface
{
    public function search($query, array $mapping)
    {
        $builder = DB::table('seo_rules')
            ->select([
                'seo_rules.id',
                'seo.*',
                DB::raw("'seo-rules' AS type"),
                DB::raw("'SEO правила' AS type_ru"),
                DB::raw("
                    CONCAT_WS('/', 'https://medeq.ru', seo_rules.url) AS public_url
                "),
                DB::raw("
                    CONCAT_WS('/', 'https://control.medeq.ru/seo-rules', seo_rules.id, 'update') AS admin_url
                ")
            ])
            ->leftJoin('seo', function ($leftJoin) {
                $leftJoin->on('seo.seoable_id', '=', 'seo_rules.id')
                    ->where('seo.seoable_type', 'LIKE', '%seorule%');
            })
        ;

        foreach ($mapping['columns'] as $column) {
            $builder->orWhere(
                DB::raw("regexp_replace({$column}, '[^A-ZА-Яа-яa-z0-9]', '')"),
                'LIKE',
                "%{$query}%"
            );
        }

        return $builder;
    }
}
