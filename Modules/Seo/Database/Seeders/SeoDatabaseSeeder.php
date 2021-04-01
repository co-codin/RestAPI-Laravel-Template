<?php

namespace Modules\Seo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Seo\Models\SeoRule;

class SeoDatabaseSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->getSeoRules() as $rule) {
            $seoRule = SeoRule::create(Arr::except($rule, 'seo'));
            $seoRule->seo()->create($rule['seo']);
        }
    }

    protected function getSeoRules()
    {
        return [
            [
                'name' => 'Главная страница',
                'url' => '/',
                'seo' => [
                    'title' => 'test',
                    'h1' => '<h1>test</h1>',
                    'description' => 'main page',
                    'is_enabled' => true,
                ],
            ]
        ];
    }
}
