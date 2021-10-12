<?php

namespace App\Console\Commands\Migration;

use App\Models\FieldValue;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class MigrateFieldValue extends Command
{
    protected $signature = 'migrate:field-values';

    protected $description = 'Migrate default field values';

    protected $fieldValues = [
        ['value' => 'Да', 'slug' => 'yes'],
        ['value' => 'Нет', 'slug' => 'no'],
        ['value' => 'Лидер продаж', 'slug' => 'leaders'],
        ['value' => 'Медэк рекомендует', 'slug' => 'medeq-recommend'],
        ['value' => 'Лучшая цена', 'slug' => 'best-price'],
        ['value' => '-10%', 'slug' => 'no'],
        ['value' => 'Экспертный', 'slug' => 'expert'],
        ['value' => 'Идеальное решение', 'slug' => 'best-choice'],
        ['value' => 'Новинка', 'slug' => 'new'],
        ['value' => 'Выбор покупателей', 'slug' => 'best-seller'],
        ['value' => 'Сумка в подарок', 'slug' => 'gift'],
        ['value' => 'Трехлетняя гарантия', 'slug' => '3-year-warranty'],
        ['value' => 'Россия', 'slug' => 'russia'],
    ];

    public function handle()
    {
        Model::unguard();

        foreach ($this->fieldValues as $fieldValue) {
            FieldValue::query()->create($fieldValue);
        }
    }
}
