<?php

namespace App\Services\Search;

use App\Services\Interfaces\SearchInterface;
use Illuminate\Support\Facades\DB;

class PageSearch implements SearchInterface
{
    public function search($query, array $mapping)
    {
        $builder = DB::table('pages')
            ->selectRaw('
                pages.id
	            "pages" AS type
	            "Страницы" AS type_ru
                CONCAT_WS("/", "https://medeq.ru", "page", slug) AS public_url
                CONCAT_WS("/", "https://control.medeq.ru/pages", pages.id, "update") AS admin_url
            ')
            ->leftJoin('seo', function ($leftJoin) {
                $leftJoin->on('seo.seoable_id', '=', 'pages.id')
                    ->where('seo.seable_type', 'LIKE', '%page%');
            })
            ;

        foreach ($mapping['columns'] as $column) {
            $builder->orWhereRaw("regexp_replace({$column}, '[^A-ZА-Яа-яa-z0-9]', '') LIKE %{$query}% OR");
        }

        return $builder;
    }
}
