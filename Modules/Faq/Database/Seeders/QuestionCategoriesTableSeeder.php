<?php


namespace Modules\Faq\Database\Seeders;


use App\Enums\Status;
use Illuminate\Database\Seeder;
use Modules\Faq\Models\QuestionCategory;

class QuestionCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->getData() as $item) {
            QuestionCategory::query()->create($item);
        }
    }

    protected function getData()
    {
        return [
            [
                'name' => 'Dog',
                'status' => Status::ACTIVE,
                'position' => 1,
            ],
            [
                'name' => 'Cat',
                'status' => Status::ACTIVE,
                'position' => 2,
            ],
            [
                'name' => 'Parrot',
                'status' => Status::INACTIVE,
                'position' => 3,
            ]
        ];
    }
}
