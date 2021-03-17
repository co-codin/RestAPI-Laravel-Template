<?php

namespace Modules\Achievement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Achievement\Models\Achievement;

class AchievementDatabaseSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->achievements() as $achievement) {
            Achievement::query()->create($achievement);
        }
    }

    protected function achievements() : array
    {
        return [
            ['name' => "Рост выручки за 2017 - 59%", "status" => true, 'image' => '/img/about-progress3.png'],
            ["name" => "Рост выручки за 2018 - 63%","status" => true, "image" => "/img/about-progress4.png"],
            ["name" => "Рост выручки за 2019 - 64%","status" => true, "image" => "/img/about-progress5.png"],
            ["name" => "Финалист “Предприниматель года 2019” от EY","status" => true, "image" => "/img/about-progress6.png"],
            ["name" => "Победитель “Выбор делового интернета” от BFM","status" => true, "image" => "/img/about-progress7.png"],
            ["name" => "Ни одной жалобы от клиентов с начала работы","status" => true, "image" => "/img/about-progress9.png"],
            ["name" => "Дилер Samsung #1 - 4 года подряд (в частном рынке)","status" => true, "image" => "/img/about-progress10.png"],
            ["name" => "Дистрибьютор Mindray #1 - 2 года подряд (по кол-ву проданных шт.)","status" => true, "image" => "/img/about-progress8.png"],
            ["name" => "Лучший темп роста Drager в 2019 году","status" => true, "image" => "/img/about-progress1.png"],
            ["name" => "Лучший темп роста Canon в 2019 году","status" => true, "image" => "/img/about-progress2.png"],
        ];
    }
}
