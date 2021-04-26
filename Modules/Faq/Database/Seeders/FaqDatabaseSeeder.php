<?php

namespace Modules\Faq\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FaqDatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(QuestionCategoriesTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
    }
}
