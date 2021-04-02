<?php


namespace Modules\Faq\Database\Seeders;


use App\Enums\Status;
use Illuminate\Database\Seeder;
use Modules\Faq\Models\QuestionCategory;

class QuestionTableSeeder extends Seeder
{
    public function run()
    {
        foreach (QuestionCategory::all() as $questionCategory) {
            foreach ($this->getData() as $item) {
                $questionCategory->questions()->create($item);
            }
        }
    }

    protected function getData()
    {
        return [
            [
                'question' => 'Dog question 1',
                'answer' => 'Dog answer 1',
                'status' => Status::ACTIVE,
            ],
            [
                'question' => 'Dog question 2',
                'answer' => 'Dog answer 2',
                'status' => Status::ACTIVE,

            ],

            [
                'question' => 'Cat question 1',
                'answer' => 'Cat answer 1',
                'status' => Status::ACTIVE,
            ],
            [
                'question' => 'Cat question 2',
                'answer' => 'Cat answer 2',
                'status' => Status::INACTIVE,
            ],

            [
                'question' => 'Parrot question 1',
                'answer' => 'Parrot answer 1',
                'status' => Status::INACTIVE,
            ],
            [
                'question' => 'Parrot question 2',
                'answer' => 'Parrot answer 2',
                'status' => Status::ACTIVE,
            ],
        ];
    }
}
