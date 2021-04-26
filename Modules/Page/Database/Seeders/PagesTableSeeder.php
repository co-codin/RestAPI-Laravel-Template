<?php

namespace Modules\Page\Database\Seeders;

use App\Enums\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Page\Models\Page;

class PagesTableSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            [
                'name' => 'Контакты',
                'slug' => 'contacts',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'О нас',
                'slug' => 'about',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Инвесторам',
                'slug' => 'invest',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Дилерам',
                'slug' => 'dealers',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Пресса',
                'slug' => 'press',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Пользовательское соглашение',
                'slug' => 'agreement',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Использование cookies',
                'slug' => 'cookies',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Персональные данные',
                'slug' => 'privacy',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Доставка',
                'slug' => 'delivery',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Лизинг',
                'slug' => 'lizing',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Партнерская программа',
                'slug' => 'partner',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Ремонт оборудования',
                'slug' => 'service',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Наша команда',
                'slug' => 'team',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Оплата',
                'slug' => 'payment',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Гарантия',
                'slug' => 'warranty',
                'status' => Status::ACTIVE,
            ],
            [
                'name' => 'Расчет стоимости доставки груза',
                'slug' => 'calculate',
                'status' => Status::ACTIVE,
                'parent' => 'delivery',
            ],
            [
                'name' => 'Этапы сделки',
                'slug' => 'steps',
                'status' => Status::ACTIVE,
                'parent' => 'delivery',
            ],
            [
                'name' => 'Информация о доставке',
                'slug' => 'info',
                'status' => Status::ACTIVE,
                'parent' => 'delivery',
            ],
        ];

        foreach($pages as $page)
        {
            if($parent = Arr::pull($page, 'parent')) {
                $page['parent_id'] = Page::firstWhere(['slug' => $parent])->id;
            }
            Page::create($page);
        }
    }
}
